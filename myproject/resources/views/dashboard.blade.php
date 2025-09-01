<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #1e1e2f, #121212);
            color: #fff;
            font-family: 'Segoe UI', sans-serif;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 40px;
            width: 400px;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
            text-align: center;
        }

        h1 {
            font-size: 2rem;
            font-weight: 600;
        }

        p {
            font-size: 1rem;
            color: #ddd;
        }

        .btn-logout {
            margin-top: 20px;
            background: #ff4d4d;
            border: none;
            border-radius: 12px;
            padding: 10px 20px;
            font-weight: bold;
            color: #fff;
            transition: 0.3s;
        }

        .btn-logout:hover {
            background: #ff6666;
            transform: scale(1.05);
        }

        .emoji {
            font-size: 2rem;
        }
    </style>
</head>
<body>

    <div class="glass-card">
        <h1>Welcome, {{ Auth::user()->name }} <span class="emoji">🎉</span></h1>
        <p>You are logged in with email: <strong>{{ Auth::user()->email }}</strong></p>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-logout">Logout</button>
        </form>
    </div>

</body>
</html>
