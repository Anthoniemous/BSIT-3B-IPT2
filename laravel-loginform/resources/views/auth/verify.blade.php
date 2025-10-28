<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email</title>

    {{-- Link to your custom CSS --}}
    <link rel="stylesheet" href="{{ asset('auth/verify.css') }}">
</head>
<body>

    <div class="verify-container">
        <div class="verify-card">
            <div class="verify-header">
                <h2>Verify Your Email Address</h2>
            </div>

            <div class="verify-body">
                <p>
                    Before proceeding, please check your email for a verification link.
                    If you did not receive the email, you can request another one below.
                </p>

                @if (session('message'))
                    <div class="alert success">
                        {{ session('message') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <button type="submit" class="resend-btn">
                        Resend Verification Email
                    </button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>
