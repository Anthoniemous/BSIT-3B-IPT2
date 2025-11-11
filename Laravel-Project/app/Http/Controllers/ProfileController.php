<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\User;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        return view('profile.edit', ['user' => $request->user()]);
    }

    public function update(Request $request)
    {
        $user = $request->user();
        $user->fill($request->only(['name', 'email'])); // example fields
        $user->save();

        $this->syncUsersToLocal(); // ✅ Sync JSON + XML

        return redirect()->route('profile.edit')->with('status', 'Profile updated');
    }

    public function destroy(Request $request)
    {
        $user = $request->user();
        Auth::logout();
        $user->delete();

        $this->syncUsersToLocal(); // ✅ Sync JSON + XML

        return redirect('/')->with('success', 'User deleted');
    }

    // 🔸 Private helper: sync JSON + XML
    private function syncUsersToLocal()
    {
        $users = User::all();
        $jsonFolder = 'USERS';
        $xmlFolder = 'USERS';

        $this->ensureFolderExists(storage_path("app/local_activity/$jsonFolder"));
        $this->ensureFolderExists(storage_path("app/local_activity/XML/$xmlFolder"));

        // JSON
        Storage::disk('local_activity')->put("$jsonFolder/users.json", $users->toJson(JSON_PRETTY_PRINT));

        // XML
        $xmlContent = $this->convertToXml($users, 'users', 'user');
        Storage::disk('local_activity')->put("XML/$xmlFolder/users.xml", $xmlContent);
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
