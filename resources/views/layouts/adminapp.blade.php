<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Skin911 Admin Panel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #fff 60%, #ffe4ec 100%);
            font-family: 'Segoe UI', Arial, sans-serif;
            min-height: 100vh;
        }
        .admin-header {
            background: #fff;
            border-bottom: 2px solid #ffe4ec;
            padding: 24px 0 12px 0;
            text-align: center;
        }
        .admin-header h1 {
            font-size: 2.2rem;
            color: #e75480;
            font-weight: bold;
            margin: 0;
        }
        .admin-content {
            padding: 32px 0;
        }
        .sidebar {
            background: #fff;
            border-right: 1px solid #ffe4ec;
            min-height: 100vh;
        }
        .sidebar .nav-link,
        .sidebar .nav-link:visited,
        .sidebar .nav-link:active,
        .sidebar .nav-link:focus,
        .sidebar .nav-link:hover,
        .sidebar .nav-link i {
            color: #e75480 !important;
        }
        .btn-admin {
            background: #e75480;
            color: #fff;
            border-radius: 8px;
            font-weight: 600;
        }
        .btn-admin:hover {
            background: #d13c6a;
        }
    </style>
    @yield('head')
</head>
<body>
    <div class="admin-header">
        @php
            $adminUser = auth('admin')->user();
            $branchName = '';
            if ($adminUser && $adminUser->branch_id) {
                $branch = \App\Models\Branch::find($adminUser->branch_id);
                $branchName = $branch ? $branch->name : '';
            }
        @endphp
        <h1>Skin911 {{ $branchName ? $branchName . ' Branch' : '' }} Admin Panel</h1>
    </div>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-2 d-none d-md-block sidebar">
                <ul class="mt-4 nav flex-column">
                    <li class="mb-2 nav-item">
                        <a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="mr-2 fa fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li class="mb-2 nav-item">
                        <a class="nav-link" href="{{ route('admin.branchmanagement') }}"><i class="mr-2 fa fa-building"></i> Branch Management</a>
                    </li>
                    <li class="mb-2 nav-item">
                        <a class="nav-link" href="{{ route('admin.promo') }}"><i class="mr-2 fa fa-gift"></i> Promo</a>
                    </li>
                    <li class="mb-2 nav-item">
                        <a class="nav-link" href="{{ route('admin.usermanage') }}"><i class="mr-2 fa fa-users"></i> User Management</a>
                    </li>
                </ul>
            </nav>
            <!-- Main Content -->
            <main role="main" class="px-4 py-4 col-md-10 ml-sm-auto admin-content">
                @if(session('success'))
                    <div class="alert alert-success" style="background:#e75480;color:#fff;border-radius:8px;border:none;">{{ session('success') }}</div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>
    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="position:fixed;bottom:24px;left:32px;z-index:999;">
        @csrf
        <button type="submit" class="btn btn-admin" style="box-shadow:0 2px 8px rgba(231,84,128,0.12);font-size:1.1rem;padding:10px 28px;">
            <i class="mr-2 fa fa-sign-out"></i> Log Out
        </button>
    </form>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
