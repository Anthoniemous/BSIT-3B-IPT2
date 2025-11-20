<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        $user = $request->user();
        return view('profile.profile', compact('user'));
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        
        // Update name + email
        $user->fill($request->validated());

        // Optional password update
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        // Avatar upload
        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $user->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        // 🔥 SYNC USERS JSON + XML
        $this->syncUsers();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // 🔥 SYNC USERS JSON + XML (rebuild after delete)
        $this->syncUsers();

        return Redirect::to('/');
    }


    // -------------------------------------------------------
    // 🔥 AUTO JSON + XML OUTPUT FOR USERS
    // -------------------------------------------------------
    private function syncUsers()
    {
        $users = User::all();

        // Save JSON
        Storage::disk('quibo_activity')->put(
            'users.json',
            $users->toJson(JSON_PRETTY_PRINT)
        );

        // Save XML
        $xmlContent = $this->convertToXml($users, 'users', 'user');
        Storage::disk('xml_activity')->put('users.xml', $xmlContent);
    }

    private function convertToXml($data, $rootElement, $itemElement)
    {
        $xml = new \SimpleXMLElement("<{$rootElement}></{$rootElement}>");

        foreach ($data as $record) {
            $item = $xml->addChild($itemElement);

            foreach ($record->toArray() as $key => $value) {
                $item->addChild($key, htmlspecialchars($value));
            }
        }

        return $xml->asXML();
    }
}
