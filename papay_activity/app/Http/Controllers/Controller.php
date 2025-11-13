<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\User;
use App\Models\Admin;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class Controller extends BaseController
{
    use \Illuminate\Foundation\Auth\Access\AuthorizesRequests;
    use \Illuminate\Foundation\Bus\DispatchesJobs;
    use \Illuminate\Foundation\Validation\ValidatesRequests;

    // Show login page
    public function showLogin()
    {
        return view('login');
    }

    // Handle login
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required','email'],
            'password' => ['required'],
        ]);

        $credentials = $request->only('email', 'password');

        // Check if admin first
        $admin = Admin::where('email', $credentials['email'])->first();

        if ($admin && Hash::check($credentials['password'], $admin->password)) {
            Auth::guard('admin')->login($admin);
            return redirect()->route('dashboard')->with('success', 'Welcome Admin!');
        }

        // Else, proceed with normal user login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (! Auth::user()->hasVerifiedEmail()) {
                Auth::logout(); 
                return redirect()->route('verification.notice')
                    ->with('error', 'Please verify your email before logging in.'); 
            }

            return redirect()->route('user.dashboard')->with('success', 'Welcome User!');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    // Show register page
    public function showRegister()
    {
        return view('register'); 
    }

    // Handle registration
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','email','unique:users'],
            'password' => ['required','confirmed','min:8'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        // Fire event to send verification email
        event(new \Illuminate\Auth\Events\Registered($user));

        // ✅ Sync new user to local JSON
        $this->syncUsersToLocal();

        Auth::login($user);

        return redirect()->route('verification.notice')
            ->with('success', 'Registration successful! Please verify your email before continuing.');
    }

    // Handle logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('welcome')->with('success', 'You have been logged out.');
    }

    // Google login redirect
    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            ->with(['prompt' => 'select_account'])
            ->redirect();
    }

    // Google login callback
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            $user = User::firstOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'name' => $googleUser->getName(),
                    'password' => bcrypt(Str::random(16)),
                    'email_verified_at' => now(),
                ]
            );

            Auth::login($user);

            // ✅ Sync to local JSON (Google sign-in)
            $this->syncUsersToLocal();

            return redirect()->route('user.dashboard');

        } catch (\Exception $e) {
            dd($e->getMessage(), $e->getCode(), $e->getTraceAsString());
        }
    }

    // 🔸 Private helper for JSON & XML sync
    private function syncUsersToLocal()
    {
        $users = User::all();

        $jsonFolder = 'USERS';
        $xmlFolder = 'USERS';

        // Ensure folders exist
        $this->ensureFolderExists(storage_path("app/papay_activity/$jsonFolder"));
        $this->ensureFolderExists(storage_path("app/papay_activity/XML/$xmlFolder"));

        // JSON
        Storage::disk('papay_activity')->put("$jsonFolder/users.json", $users->toJson(JSON_PRETTY_PRINT));

        // XML
        $xmlContent = $this->convertToXml($users, 'users', 'user');
        Storage::disk('papay_activity')->put("XML/$xmlFolder/users.xml", $xmlContent);
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
