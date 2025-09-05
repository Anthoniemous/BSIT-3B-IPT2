<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $verification_code = bin2hex(random_bytes(32));

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'verification_code' => $verification_code,
            'is_verified' => 0,
        ]);

        // Send verification email using PHPMailer
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'yourgmail@gmail.com';
            $mail->Password = 'your-app-password';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('yourgmail@gmail.com', 'Your App Name');
            $mail->addAddress($user->email);
            $mail->isHTML(true);
            $mail->Subject = 'Email Verification';
            $mail->Body = "Click the link to verify your email: <a href='" . route('verify.email', $verification_code) . "'>Verify Email</a>";

            $mail->send();
        } catch (Exception $e) {
            return back()->with('error', 'Could not send verification email. Error: ' . $mail->ErrorInfo);
        }

        return redirect()->route('register.form')->with('success', 'Registration successful! Check your email to verify your account.');
    }
}
