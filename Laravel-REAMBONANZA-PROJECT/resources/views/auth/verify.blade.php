<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Verify Your Email</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
</head>
<body style="font-family: Arial, sans-serif; padding: 2rem;">
    <h2>Verify your email address</h2>

    @if(session('message'))
        <div style="background:#e6ffed; padding:10px; border-radius:6px; margin-bottom:12px;">
            {{ session('message') }}
        </div>
    @endif

    <p>
        Thanks for signing up! Before continuing, please check your email for a verification link.
        If you did not receive the email, you can request another one.
    </p>

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" style="padding:10px 14px; border-radius:6px; cursor:pointer;">
            Resend verification email
        </button>
    </form>

    <p style="margin-top:12px;">
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
    </p>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
        @csrf
    </form>
</body>
</html>
