<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login - Skin911</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin/adminlogin.css') }}">
</head>
<body>
    <div class="login-container">
        <img src="/img/skinlogo.png" alt="Skin911 Logo" class="logo">
        <h2>Admin Login</h2>
        <form method="POST" action="{{ route('admin.adminlogin') }}">
            @csrf
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required autofocus>

            <label for="password">Password</label>
            <div style="position:relative;">
                <input type="password" id="admin-password" name="password" required style="padding-right:40px;">
                <i class="fa fa-eye" id="toggleAdminPassword" style="position:absolute; right:12px; top:50%; transform:translateY(-50%); cursor:pointer; color:#e75480;"></i>
            </div>

            <div style="text-align:left;margin-bottom:16px;">
                <input type="checkbox" id="remember" name="remember" style="margin-right:6px;">
                <label for="remember" style="display:inline;color:#e75480;font-weight:500;">Remember me</label>
            </div>

            <input type="submit" value="Login">
            @if($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif
        </form>
        <div class="footer">
            &copy; {{ date('Y') }} Skin911. All rights reserved.
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleAdminPassword = document.getElementById('toggleAdminPassword');
            const adminPassword = document.getElementById('admin-password');

            if (toggleAdminPassword && adminPassword) {
                toggleAdminPassword.addEventListener('click', function() {
                    const type = adminPassword.getAttribute('type') === 'password' ? 'text' : 'password';
                    adminPassword.setAttribute('type', type);
                    this.classList.toggle('fa-eye');
                    this.classList.toggle('fa-eye-slash');
                });
            }
        });
    </script>
</body>
</html>
