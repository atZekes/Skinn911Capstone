<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CEO Login - Skin911</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="theme-color" content="#e75480">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer">
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
            <div style="position:relative;">
                <input type="password" id="ceo-password" name="password" required style="padding-right:45px;">
                <i class="fas fa-eye" id="toggleCeoPassword" style="position:absolute; right:12px; top:50%; transform:translateY(-50%); cursor:pointer; color:#e75480; font-size:18px;"></i>
            </div>

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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleCeoPassword = document.getElementById('toggleCeoPassword');
            const ceoPassword = document.getElementById('ceo-password');

            if (toggleCeoPassword && ceoPassword) {
                toggleCeoPassword.addEventListener('click', function() {
                    const type = ceoPassword.getAttribute('type') === 'password' ? 'text' : 'password';
                    ceoPassword.setAttribute('type', type);
                    this.classList.toggle('fa-eye');
                    this.classList.toggle('fa-eye-slash');
                });
            }
        });
    </script>
</body>
</html>
