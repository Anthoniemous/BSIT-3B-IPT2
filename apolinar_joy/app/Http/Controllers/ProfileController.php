<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\User;

class ProfileController extends Controller
{
    // Edit profile page
    public function edit(Request $request)
    {
        return view('profile.edit', ['user' => $request->user()]);
    }

    // Update profile (name, email, etc.)
    public function update(Request $request)
    {
        $user = $request->user();
        $user->fill($request->only(['name', 'email'])); // example fields
        $user->save();

        $this->syncUsersToLocal(); // ✅ Sync JSON + XML

        return redirect()->route('profile.edit')->with('status', 'Profile updated');
    }

    // Delete user account
    public function destroy(Request $request)
    {
        $user = $request->user();
        Auth::logout();
        $user->delete();

        $this->syncUsersToLocal(); // ✅ Sync JSON + XML

        return redirect('/')->with('success', 'User deleted');
    }

    // Update profile photo
    public function updatePhoto(Request $request)
    {
        $request->validate([
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $user = $request->user();

        // Delete old photo if exists
        if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
            Storage::disk('public')->delete($user->profile_photo);
        }

        // Store new photo
        $path = $request->file('profile_photo')->store('profiles', 'public');
        $user->profile_photo = $path;
        $user->save();

        // Sync to JSON + XML
        $this->syncUsersToLocal();

        return back()->with('success', 'Profile photo updated!');
    }

    // 🔸 Private helper: sync JSON + XML
    private function syncUsersToLocal()
    {
        $users = User::all();
        $jsonFolder = 'USERS';
        $xmlFolder = 'USERS';

        $this->ensureFolderExists(storage_path("app/apolinar_activity/$jsonFolder"));
        $this->ensureFolderExists(storage_path("app/apolinar_activity/XML/$xmlFolder"));

        // JSON
        Storage::disk('apolinar_activity')->put("$jsonFolder/users.json", $users->toJson(JSON_PRETTY_PRINT));

        // XML
        $xmlContent = $this->convertToXml($users, 'users', 'user');
        Storage::disk('apolinar_activity')->put("XML/$xmlFolder/users.xml", $xmlContent);
    }

    // 🔹 Convert collection to XML
    private function convertToXml($data, $rootElement = 'items', $itemElement = 'item')
    {
        $xml = new \SimpleXMLElement("<?xml version=\"1.0\"?><$rootElement></$rootElement>");
        foreach ($data as $record) {
            $item = $xml->addChild($itemElement);
            foreach ($record->toArray() as $key => $value) {
                $item->addChild($key, htmlspecialchars($value));
            }
        }
        return $xml->asXML();
    }

    // 🔹 Ensure folder exists
    private function ensureFolderExists($folderPath)
    {
        if (!File::exists($folderPath)) {
            File::makeDirectory($folderPath, 0755, true);
        }
    }
}
