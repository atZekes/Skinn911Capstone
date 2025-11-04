<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Skin911</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="{{ asset('css/admin/adminlogin.css') }}" rel="stylesheet">
</head>
<style>
    body {
    background: linear-gradient(135deg, #fffbfb 60%, #eeeaeb 100%) !important;
    min-height: 100vh;
    position: relative;
}

.admin-bg {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    z-index: 0;
    background: url('../img/bglogin-signup.jpg') center center/cover no-repeat;
    opacity: 1;
}
</style>
<body>
    <div class="admin-bg"></div>
    <div class="mx-auto login-container">
        <img src="{{ asset('img/skinlogo.png') }}" alt="Skin911 Logo" class="mx-auto mb-4 skin911-logo d-block">
        <h3 class="mb-4 text-center" style="color:#e75480;font-weight:700;">Admin Login emman kupal</h3>
        <form method="POST" action="{{ route('admin.adminlogin') }}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" name="email" required autofocus placeholder="Enter admin email">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div style="position:relative;">
                    <input type="password" class="form-control" id="admin-password" name="password" required placeholder="Enter password" style="padding-right:40px;">
                    <i class="fa fa-eye" id="toggleAdminPassword" style="position:absolute; right:12px; top:50%; transform:translateY(-50%); cursor:pointer; color:#e75480;"></i>
                </div>
            </div>
            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="remember" name="remember">
                    <label class="form-check-label" for="remember">Remember me</label>
                </div>
            </div>
            <button type="submit" class="btn btn-admin w-100">Login</button>
        </form>
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
