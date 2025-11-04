<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Login</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            background: url('/img/banner1111.png') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Montserrat', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-container {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            padding: 40px 32px;
            max-width: 400px;
            width: 100%;
            text-align: center;
        }
        .login-container h2 {
            color: #e75480;
            margin-bottom: 24px;
            font-weight: 700;
        }
        .form-group {
            margin-bottom: 18px;
            text-align: center;
        }
        .form-group label {
            color: #e75480;
            font-weight: 600;
            display: block;
            margin-bottom: 6px;
        }
        .form-control {
            width: 80%;
            margin: 0 auto;
            padding: 10px 12px;
            border-radius: 8px;
            border: 1px solid #e75480;
            font-size: 16px;
            display: block;
        }
        .btn-primary {
            background: linear-gradient(90deg, #e75480 0%, #ffb6c1 100%);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 12px 0;
            width: 100%;
            font-size: 18px;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.3s;
        }
        .btn-primary:hover {
            background: linear-gradient(90deg, #ffb6c1 0%, #e75480 100%);
        }
        .alert-danger {
            background: #ffe4ec;
            color: #e75480;
            border-radius: 8px;
            padding: 10px;
            margin-top: 10px;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="login-container">
        <img src="/img/skinlogo.png" alt="Logo" style="width:120px; margin-bottom:18px;">
        <h2>Staff Login</h2>
        <form method="POST" action="{{ route('staff.login.submit') }}">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" required autofocus>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <div style="position:relative; width:80%; margin:0 auto;">
                    <input id="staff-password" type="password" name="password" class="form-control" required style="width:100%; padding-right:40px;">
                    <i class="fa fa-eye" id="toggleStaffPassword" style="position:absolute; right:12px; top:50%; transform:translateY(-50%); cursor:pointer; color:#e75480;"></i>
                </div>
            </div>
            <div class="form-group" style="display:flex; align-items:center; gap:8px; width:80%; margin:0 auto 12px;">
                <input class="form-check-input" type="checkbox" id="remember" name="remember" style="margin:0;">
                <label class="form-check-label" for="remember" style="color:#e75480; margin:0;">Remember me</label>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
            @if($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif
        </form>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleStaffPassword = document.getElementById('toggleStaffPassword');
            const staffPassword = document.getElementById('staff-password');
            
            if (toggleStaffPassword && staffPassword) {
                toggleStaffPassword.addEventListener('click', function() {
                    const type = staffPassword.getAttribute('type') === 'password' ? 'text' : 'password';
                    staffPassword.setAttribute('type', type);
                    this.classList.toggle('fa-eye');
                    this.classList.toggle('fa-eye-slash');
                });
            }
        });
    </script>
</body>
</html>
