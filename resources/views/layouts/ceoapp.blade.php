<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CEO Dashboard - Skin911</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="format-detection" content="telephone=no">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <!-- Bootstrap CSS for modern components -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Chart.js for data visualization -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- SweetAlert2 for better notifications -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



    <!-- CEO specific stylesheets -->
    <link rel="stylesheet" href="{{ asset('css/CEO/layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/CEO/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/CEO/adduseradmin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/CEO/usermanage.css') }}">

    <!-- Page specific styles (loaded after base styles) -->
    @yield('styles')
</head>
<body>
    <!-- Mobile menu toggle button (only visible on mobile) -->
    <button class="mobile-menu-toggle" id="mobileMenuToggle">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Mobile overlay (only visible when menu is open on mobile) -->
    <div class="mobile-overlay" id="mobileOverlay"></div>

    <div class="ceo-layout">
        <!-- Left sidebar with navigation -->
        <div class="ceo-sidebar" id="ceoSidebar">
            <!-- Company branding area -->
            <div class="ceo-brand">
                <h3><i class="fas fa-crown"></i> Skin911</h3>
                <p>CEO Management Panel</p>
            </div>

            <!-- Navigation menu -->
            <div class="ceo-tabs">
                <a class="ceo-tab @if(request()->routeIs('ceo.dashboard')) active @endif" href="{{ route('ceo.dashboard') }}">
                    <i class="fas fa-chart-line"></i> Dashboard
                </a>
                <a class="ceo-tab @if(request()->routeIs('ceo.branchmanagement')) active @endif" href="{{ route('ceo.branchmanagement') }}">
                    <i class="fas fa-building"></i> Branch Management
                </a>
                <a class="ceo-tab @if(request()->routeIs('ceo.usermanage')) active @endif" href="{{ route('ceo.usermanage') }}">
                    <i class="fas fa-users"></i> User Management
                </a>
            </div>

            <!-- Logout button at bottom -->
            <a href="{{ route('ceo.logout') }}" class="btn-logout-ceo">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>

        <!-- Main content area -->
        <div class="ceo-main">
            <!-- Top header with page title -->
            <div class="ceo-header">
                <h1>
                    @if(request()->routeIs('ceo.dashboard'))
                        <i class="fas fa-chart-line me-2"></i>Executive Dashboard
                    @elseif(request()->routeIs('ceo.branchmanagement'))
                        <i class="fas fa-building me-2"></i>Branch Management
                    @elseif(request()->routeIs('ceo.adduseradmin'))
                        <i class="fas fa-user-plus me-2"></i>Add User/Admin
                    @elseif(request()->routeIs('ceo.usermanage'))
                        <i class="fas fa-users me-2"></i>User Management
                    @else
                        <i class="fas fa-crown me-2"></i>CEO Panel
                    @endif
                </h1>
                <p>Manage your business operations and monitor performance</p>
            </div>

            <!-- Content container -->
            <div class="ceo-content">
                @yield('dashboard')
                @yield('branch')
                @yield('usermanage')
            </div>
        </div>
    </div>

    <!-- Bootstrap JavaScript for interactive components -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Mobile menu functionality -->
    <!-- CEO specific JavaScript -->
    <script src="{{ asset('js/CEO/layout.js') }}"></script>

    @if(request()->routeIs('ceo.usermanage'))
        <script src="{{ asset('js/CEO/usermanage.js') }}"></script>
    @elseif(request()->routeIs('ceo.branchmanagement'))
        <script src="{{ asset('js/CEO/branchmanagement.js') }}"></script>
    @endif

    @yield('scripts')
</body>
</html>
