<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Profile</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700&display=swap" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #fff 60%, #ffe4ec 100%);
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            min-height: 100vh;
        }
        .profile-container {
            max-width: 500px;
            margin: 60px auto;
            background: #fff;
            border-radius: 24px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
            padding: 48px 36px;
            text-align: center;
        }
        .profile-header img {
            width: 80px;
            margin-bottom: 18px;
        }
        .profile-header h1 {
            color: #e75480;
            font-size: 2rem;
            font-weight: 700;
            margin: 0 0 18px 0;
        }
        .profile-details {
            color: #333;
            font-size: 1.1rem;
            margin-bottom: 18px;
        }
        .profile-details strong {
            color: #e75480;
        }
        .btn {
            background: linear-gradient(90deg, #e75480 0%, #ffb6c1 100%);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 12px 32px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            margin-top: 24px;
            transition: background 0.3s;
        }
        .btn:hover {
            background: linear-gradient(90deg, #ffb6c1 0%, #e75480 100%);
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <div class="profile-header">
            <img src="/img/logo.png" alt="Logo">
            <h1>Staff Profile</h1>
        </div>
        @if(isset($staff))
            <div class="profile-details">
                <p><strong>Name:</strong> {{ $staff->name }}</p>
                <p><strong>Email:</strong> {{ $staff->email }}</p>
                <p><strong>Role:</strong> {{ $staff->role }}</p>
            </div>
            <a href="{{ route('staff.index') }}" class="btn">Back to Staff Home</a>
        @else
            <p>Staff profile not found.</p>
        @endif
    </div>
</body>
</html>
