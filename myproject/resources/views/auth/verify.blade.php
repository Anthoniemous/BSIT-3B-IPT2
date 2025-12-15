<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email</title>
</head>
<body style="font-family: Arial, sans-serif; padding: 30px;">

    <h2>Email Verification</h2>

    @if (session('message'))
        <p style="color: green;">{{ session('message') }}</p>
    @endif

    @if (session('status') === 'verification-link-sent')
        <p style="color: green;">✅ Verification link sent! Please check your email.</p>
    @endif

    <p>We sent a verification link to your email. Please verify to continue.</p>

    <form method="POST" action="{{ route('verification.resend') }}">
        @csrf
        <button type="submit" style="padding: 10px 15px; cursor: pointer;">
            Resend Verification Email
        </button>
    </form>

    <form method="POST" action="{{ route('logout') }}" style="margin-top: 15px;">
        @csrf
        <button type="submit" style="padding: 10px 15px; cursor: pointer;">
            Logout
        </button>
    </form>

</body>
</html>
