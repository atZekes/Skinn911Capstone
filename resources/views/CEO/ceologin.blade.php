<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CEO Login - Skin911</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/CEO/ceologin.css') }}">
</head>
<body>
    <div class="login-container">
        <img src="/img/skinlogo.png" alt="Skin911 Logo" class="logo">
        <h2>CEO Login</h2>
        <form method="POST" action="{{ route('ceo.login.submit') }}">
            @csrf
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required autofocus>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <div style="text-align:left;margin-bottom:16px;">
                <input type="checkbox" id="remember" name="remember" style="margin-right:6px;">
                <label for="remember" style="display:inline;color:#e75480;font-weight:500;">Remember me</label>
            </div>

            <input type="submit" value="Login">
        </form>
        <div class="footer">
            &copy; {{ date('Y') }} Skin911. All rights reserved.
        </div>
    </div>
</body>
</html>
