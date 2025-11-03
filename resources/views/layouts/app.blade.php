<!doctype html>
<html class="no-js" lang="zxx">
<head>
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/favicon.png') }}">

    <!-- CSS here -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('css/gijgo.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('css/slicknav.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">



    <!-- Your Custom Styles -->
    <style>
    /* Hide sticky-auth-btn by default, show only when sticky */
    .sticky-auth-btn { display: none !important; }
    .main-header-area.sticky .sticky-auth-btn { display: inline-block !important; }
        /* (Your custom styles can remain here) */
        <!-- In your app.blade.php, replace the old style blocks with this one -->
    /*
     * ===============================================
     *  HEADER: TRANSPARENT AT TOP, WHITE ON SCROLL
     * ===============================================
    */

    /* --- 1. DEFAULT STATE (When at the very top of the page) --- */
    .header-area .main-header-area {
        background: transparent !important;
        transition: all 0.4s ease; /* Smooth transition for all properties */
        z-index: 1000;
    }
    /* Make menu links white */
    .header-area .main-header-area .main-menu ul li a {
        color: #fff !important;
    }
    /* Make the underline for menu links white */
    .header-area .main-header-area .main-menu ul li a::before {
        background: #fff !important;
    }
    /* Make social media icons white */
    .header-area .main-header-area .book_room .socail_links ul li a {
        color: #fff !important;
    }
    /* This filter turns your dark logo into a white version */
    .header-area .main-header-area .logo-img img {
        filter: brightness(0) invert(1);
    }
    /* Style the buttons for the transparent header */
    .header-area .main-header-area .book_room .book_btn a {
        background: transparent !important;
        border-color: #fff !important;
        color: #fff !important;
    }
    .header-area .main-header-area .book_room .book_btn a:hover {
        background: #fff !important;
        color: #F56289 !important; /* Pink text on hover */
    }


    /* --- 2. STICKY STATE (When scrolled down) --- */
    .header-area .main-header-area.sticky {
        background: #fff !important;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Add a subtle shadow */
    }
    /* Make menu links pink */
    .header-area .main-header-area.sticky .main-menu ul li a {
        color: #F56289 !important;
    }
    /* Make the underline for menu links pink */
    .header-area .main-header-area.sticky .main-menu ul li a::before {
        background: #F56289 !important;
    }
    /* Make social media icons pink */
    .header-area .main-header-area.sticky .book_room .socail_links ul li a {
        color: #F56289 !important;
    }
    /* Revert the logo back to its original color */
    .header-area .main-header-area.sticky .logo-img img {
        filter: none;
    }
    /* Style the buttons for the white sticky header */
    .header-area .main-header-area.sticky .book_room .book_btn a {
        background: #F56289 !important;
        border-color: #F56289 !important;
        color: #fff !important;
    }
    .header-area .main-header-area.sticky .book_room .book_btn a:hover {
        background: #fff !important;
        color: #F56289 !important;
    }

    /* Mobile behavior: transparent at top, white when sticky; ensure burger/menu are visible */
    @media (max-width: 991.98px) {
        .header-area .main-header-area {
            background: transparent !important;
            box-shadow: none;
        }
        .header-area .main-header-area.sticky {
            background: #fff !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.06);
        }
        /* Logo color inversion only when not sticky (on transparent bg) */
        .header-area .main-header-area:not(.sticky) .logo-img img { filter: brightness(0) invert(1); }
        .header-area .main-header-area.sticky .logo-img img { filter: none; }
        /* Auth buttons style stays visible on both states */
        .header-area .main-header-area.sticky .book_room .book_btn a {
            background: #F56289 !important;
            border-color: #F56289 !important;
            color: #fff !important;
        }
        /* Slicknav mobile menu visibility */
        .slicknav_menu { display: block !important; position: relative; z-index: 1200; }
        /* Burger icon color: white on transparent, pink on sticky */
        .header-area .main-header-area:not(.sticky) .slicknav_menu .slicknav_btn { color: #fff; border-color: #fff; }
        .header-area .main-header-area:not(.sticky) .slicknav_menu .slicknav_icon-bar { background-color: #fff; }
        .header-area .main-header-area.sticky .slicknav_menu .slicknav_btn { color: #F56289; border-color: #F56289; }
        .header-area .main-header-area.sticky .slicknav_menu .slicknav_icon-bar { background-color: #F56289; }
        /* Dropdown panel */
        .slicknav_menu .slicknav_nav { background: #fff; border-radius: 6px; box-shadow: 0 6px 20px rgba(0,0,0,0.08); }
        .slicknav_menu .slicknav_nav a { color: #333; }
    }


    /*
     * ===============================================
     *  FOOTER: WHITE BACKGROUND THEME
     * ===============================================
    */
    .footer {
        background: #fff !important;
        border-top: 1px solid #eee;  /* Add a subtle line to separate from content */
    }
    /* Make titles and text dark so they are visible on a white background */
    .footer .footer_top .footer_widget .footer_title {
    color: #F56289 !important;
    }
    .footer .footer_top .footer_widget p.footer_text,
    .footer .footer_top .footer_widget p.footer_text,
    .footer .footer_top .footer_widget ul li a {
        color: #F56289 !important;
    }
    .footer .copy-right_text .copy_right {
    color: #F56289 !important;
    }
    .footer .copy-right_text .footer_border {
        border-top: 1px solid #F56289 !important;
    }
    .footer .footer_top .footer_widget .socail_links ul li a {
        color: #F56289 !important;
    }
    .footer .footer_top .footer_widget .socail_links ul li a:hover {
        color: #F56289 !important;
    }
    </style>

    <style>
    /* ===============================================
     *  BASIC MODAL STYLES (Login, Register, Legal)
     * =============================================== */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        display: none; /* hidden by default */
        align-items: center;
        justify-content: center;
        background: rgba(0,0,0,0.55);
        z-index: 1050;
        padding: 16px;
    }
    .modal-overlay.active { display: flex; }
    .modal-content {
        background: #fff;
        border-radius: 8px;
        width: 100%;
        max-width: 520px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        position: relative;
        padding: 24px;
        max-height: 90vh;
        overflow-y: auto;
    }
    .modal-header { display:flex; align-items:center; justify-content:space-between; margin-bottom: 12px; }
    .modal-header h3 { margin:0; color:#F56289; font-family: Montserrat, sans-serif; }
    .modal-close-btn {
        cursor: pointer;
        font-size: 24px;
        line-height: 1;
        color: #999;
    }
    .modal-close-btn:hover { color: #333; }
    /* Login/Register form basics */
    .login-container { display:flex; flex-direction:column; align-items:center; }
    .input { width: 100%; padding: 12px 14px; border: 1px solid #ddd; border-radius: 6px; }
    .input-icon-group { position: relative; width:100%; margin-bottom: 12px; }
    .input-icon { position:absolute; left:10px; top:50%; transform: translateY(-50%); width:18px; height:18px; opacity:.6; }
    .input-icon-group .input { padding-left: 36px; }
    .button { width: 100%; padding: 12px; background: #F56289; color:#fff; border: none; border-radius: 6px; cursor: pointer; }
    .button:hover { opacity: .95; }

    /* Mobile/Tablet Auth Buttons */
    .mobile-auth-btn {
        display: inline-block;
        padding: 8px 14px;
        border: 2px solid #F56289;
        border-radius: 6px;
        background: #F56289;
        color: #fff !important;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 12px;
    }
    .mobile-auth-btn:hover {
        background: #fff;
        color: #F56289 !important;
    }
    </style>

</head>

<body>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var header = document.querySelector('.header-area');
    var mainHeader = document.querySelector('.main-header-area');
    function handleScroll() {
        if (window.scrollY < 10) {
            header.style.display = 'none';
            mainHeader.classList.remove('sticky');
        } else {
            header.style.display = '';
            mainHeader.classList.add('sticky');
        }
    }
    handleScroll();
    window.addEventListener('scroll', handleScroll);
});
</script>
    <!-- header-start -->
    <header>

        <div class="header-area" style="background:transparent;box-shadow:none;position:relative;z-index:1002;">
        <!-- Responsive Banner (layout-level) -->
        @unless(View::hasSection('hide_layout_banner'))
        <picture>
            <source media="(max-width: 767px)" srcset="{{ asset('img/skin2.png') }}">
            <source media="(max-width: 1199px)" srcset="{{ asset('img/banner-tablet.jpg') }}">
            <img src="{{ asset('img/banner-desktop.jpg') }}" alt="Banner" style="width:100%;height:auto;">
        </picture>
        @endunless
            <div id="sticky-header" class="main-header-area" style="background:transparent;box-shadow:none;">
                <div class="p-0 container-fluid">
                    <div class="row align-items-center no-gutters">
                        <!-- Desktop: original layout -->
                        <div class="col-xl-2 col-lg-2 d-none d-lg-flex align-items-center">
                            <div class="logo-img">
                                <a href="{{ route('home') }}">
                                    <img src="{{ asset('img/skinlogo.png') }}" alt="Skin911 Logo" style="max-height:60px;">
                                </a>
                            </div>
                        </div>
                        <div class="col-xl-5 col-lg-6 d-none d-lg-block">
                            <div class="main-menu w-100">
                                <nav>
                                    <ul id="navigation" class="flex-row nav d-flex justify-content-center align-items-center w-100" style="margin-bottom:0;gap:0;">
                                        <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
                                        <li class="nav-item"><a class="nav-link" href="{{ route('services') }}">Services</a></li>
                                        <li class="nav-item"><a class="nav-link" href="{{ route('aboutus') }}">About Us</a></li>
                                        <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">Branch Locator </a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <!-- Mobile: logo and nav side by side -->
                        <div class="d-flex d-lg-none align-items-center w-100" style="gap:16px;">
                            <div class="logo-img" style="min-width:70px;">
                                <a href="{{ route('home') }}">
                                    <img src="{{ asset('img/skinlogo.png') }}" alt="Skin911 Logo" style="max-height:40px;">
                                </a>
                            </div>
                            <div class="flex-grow-1"></div>
                            <div class="hamburger" id="mainHamburger" style="display: flex !important; align-items: center; cursor: pointer; z-index: 9999; margin-left:auto;">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                            <div id="mobileDrawer" class="mobile-drawer">
                                <div class="drawer-content">
                                    <ul class="nav flex-column" style="margin-bottom:0;">
                                        <li class="nav-item"><a class="nav-link" href="{{ route('home') }}" style="color:#F56289;font-weight:600;">Home</a></li>
                                        <li class="nav-item"><a class="nav-link" href="{{ route('services') }}" style="color:#F56289;font-weight:600;">Services</a></li>
                                        <li class="nav-item"><a class="nav-link" href="{{ route('aboutus') }}" style="color:#F56289;font-weight:600;">About Us</a></li>
                                        <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}" style="color:#F56289;font-weight:600;">Branch Locator</a></li>
                                        <li class="nav-item d-lg-none" style="margin-top:12px;">
                                            <a href="#" class="btn btn-outline-pink w-100" id="drawerLoginBtn" style="color:#F56289;border:1px solid #F56289;margin-bottom:10px;">Login</a>
                                        </li>
                                        <li class="nav-item d-lg-none">
                                            <a href="#" class="btn btn-outline-pink w-100" id="drawerRegisterBtn" style="color:#F56289;border:1px solid #F56289;">Register</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <style>
                                .hamburger {
                                    display: flex !important;
                                    flex-direction: column !important;
                                    justify-content: center !important;
                                    align-items: center !important;
                                    width: 40px;
                                    height: 40px;
                                    cursor: pointer;
                                    z-index: 9999;
                                    margin-left: auto;
                                }
                                .hamburger span {
                                    background: #e91e63 !important;
                                    display: block !important;
                                    height: 4px;
                                    margin: 4px 0 !important;
                                    width: 30px;
                                    border-radius: 2px;
                                    transition: all 0.3s;
                                }
                                /* Hide nav links in header on mobile */
                                @media (max-width: 991px) {
                                    #mainHorizontalTabs {
                                        display: none !important;
                                    }
                                }
                                /* Drawer styles */
                                .mobile-drawer {
                                    position: fixed;
                                    top: 0;
                                    right: -300px;
                                    width: 260px;
                                    height: 100vh;
                                    background: #fff;
                                    box-shadow: -2px 0 12px rgba(0,0,0,0.12);
                                    z-index: 99999;
                                    transition: right 0.3s cubic-bezier(.4,0,.2,1);
                                    display: flex;
                                    flex-direction: column;
                                    padding-top: 60px;
                                }
                                .mobile-drawer.open {
                                    right: 0;
                                }
                                .mobile-drawer .drawer-content {
                                    padding: 24px;
                                }
                                .mobile-drawer .nav-link {
                                    font-size: 1.2rem;
                                    margin-bottom: 18px;
                                }
                            </style>
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    var hamburger = document.getElementById('mainHamburger');
                                    var drawer = document.getElementById('mobileDrawer');
                                    hamburger.addEventListener('click', function() {
                                        drawer.classList.toggle('open');
                                    });
                                    // Optional: close drawer when clicking outside
                                    drawer.addEventListener('click', function(e) {
                                        if (e.target === drawer) {
                                            drawer.classList.remove('open');
                                        }
                                    });
                                    document.addEventListener('click', function(e) {
                                        if (!drawer.contains(e.target) && !hamburger.contains(e.target)) {
                                            drawer.classList.remove('open');
                                        }
                                    });
                                    // Login/Register modal triggers for mobile drawer
                                    var loginBtn = document.getElementById('drawerLoginBtn');
                                    var registerBtn = document.getElementById('drawerRegisterBtn');
                                    if (loginBtn) {
                                        loginBtn.addEventListener('click', function(e) {
                                            e.preventDefault();
                                            drawer.classList.remove('open');
                                            var loginModalBtn = document.getElementById('openLoginModalBtn');
                                            if (loginModalBtn) loginModalBtn.click();
                                        });
                                    }
                                    if (registerBtn) {
                                        registerBtn.addEventListener('click', function(e) {
                                            e.preventDefault();
                                            drawer.classList.remove('open');
                                            var registerModalBtn = document.getElementById('openRegisterModalBtn');
                                            if (registerModalBtn) registerModalBtn.click();
                                        });
                                    }
                                });
                            </script>
                        </div>
                        <div class="col-xl-5 col-lg-4 d-none d-lg-block">
                            <div class="ButtonsHeader">
                                <div class="socail_links">
                                    <!-- Social Links Here -->
                                </div>
                                <!-- Desktop Auth Buttons: Only visible when sticky -->
                                <div class="book_btn d-none d-lg-block sticky-auth-btn" style="margin-left:10px; display:none;">
                                    <a href="#" id="openLoginModalBtn">Login</a>
                                </div>
                                <div class="book_btn d-none d-lg-block sticky-auth-btn" style="margin-left:10px; display:none;">
                                    <a href="#" id="openRegisterModalBtn">Register</a>
                                </div>
                            </div>
                        </div>
                        <!-- Mobile row: auth buttons on the left, hamburger/nav on the right -->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- header-end -->

    <!-- No margin above content, slider will be visible behind navbar -->
    @yield('content')

    <!-- footer -->
    <footer class="footer">
        <!-- (Your simplified footer without the "Help" section) -->
    </footer>

    <!-- MODAL COMPONENTS (Place them here) -->
    <x-login-modal/>
    <x-register-modal/>
    <x-reset-password-modal/>

    <!-- Simple Legal Modal -->
    <div id="legalModal" class="modal-overlay" aria-hidden="true">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modalTitle"></h3>
                <span class="modal-close-btn" data-close>&times;</span>
            </div>
            <div id="modalBody"></div>
        </div>
    </div>

    <!-- JS here -->
    <script src="{{ asset('js/vendor/jquery-1.12.4.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/jquery.slicknav.min.js') }}"></script>
    <script src="{{ asset('js/jquery.ajaxchimp.min.js') }}"></script>
    <script src="{{ asset('js/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    @yield('scripts')

    <!-- VITE LOADS YOUR CUSTOM app.js LAST -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>

    <script>
    window.addEventListener('scroll', function() {
        var header = document.getElementById('sticky-header');
        if (window.scrollY > 50) {
            header.classList.add('sticky');
        } else {
            header.classList.remove('sticky');
        }
    });
    </script>

<!-- footer -->
<footer class="footer">
    <div class="footer_top">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-md-6 col-lg-3">
                    <div class="footer_widget">
                        <h3 class="footer_title">
                            Address
                        </h3>
                        <p class="footer_text"> Skin911 Premier - Banilad Town Center (Main Office)</p>
                        <a href="#" class="line-button">Get Direction</a>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 col-lg-3">
                    <div class="footer_widget">
                        <h3 class="footer_title">
                            Contact Us
                        </h3>
                        <p class="footer_text">
                            <i class="fa fa-phone"></i> 0917 396 3828<br>
                            <i class="fa fa-envelope"></i> skin911.mainofc@gmail.com
                        </p>
                    </div>
                </div>
                <div class="col-xl-2 col-md-6 col-lg-2">
                    <div class="footer_widget">
                        <h3 class="footer_title">
                            Help
                        </h3>
                        <ul>
                            <li> <a href="#" class="legal-link"
                                data-modal-title="Terms and Conditions"
                                data-modal-content-id="terms-content">Terms and Conditions</a></li>
                            <li> <a href="#" class="legal-link"
                                data-modal-title="Privacy Policy"
                                data-modal-content-id="privacy-policy-content">Privacy Policy</a></li>
                            <li>  <a href="#" class="legal-link"
                                data-modal-title="Data Privacy Statement"
                                data-modal-content-id="data-privacy-content">Data Privacy</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6 col-lg-4">
                    <div class="footer_widget">
                        <h3 class="footer_title">
                            Follow us
                        </h3>
                        <div class="socail_links">
                            <ul>
                                <li>
                                    <a href="https://www.facebook.com/Skin911Official/" target="_blank">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.instagram.com/skin911/?hl=en" target="_blank">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="copy-right_text">
        <div class="container">
            <div class="footer_border"></div>
            <div class="row">
                <div class="col-xl-12">
                    <p class="text-center copy_right">
                        Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved
                    </p>
                </div>
            </div>
        </div>
    </div>

</footer>
<!-- HIDDEN CONTENT FOR LEGAL MODALS -->
<div id="legal-hidden-contents" style="display:none;">
    <div id="terms-content">
        @include('components.legal.terms')
    </div>
    <div id="privacy-policy-content">
        @include('components.legal.privacy-policy')
    </div>
    <div id="data-privacy-content">
        @include('components.legal.data-privacy')
    </div>
</div>

<!-- Modal Wiring Script -->
<script>

(function(){
    const qs = (s, r=document) => r.querySelector(s);
    const qsa = (s, r=document) => Array.from(r.querySelectorAll(s));
    const body = document.body;

    function openModal(modal){
        if(!modal) return;
        modal.classList.add('active');
        modal.setAttribute('aria-hidden', 'false');
        body.style.overflow = 'hidden';
    }
    function closeModal(modal){
        if(!modal) return;
        modal.classList.remove('active');
        modal.setAttribute('aria-hidden', 'true');
        body.style.overflow = '';
    }

    const loginModal = qs('#loginModal');
    const registerModal = qs('#registerModal');
    const legalModal = qs('#legalModal');

    qsa('#openLoginModalBtn, #openLoginModalBtnMobile, #openLoginModalBtnMobileHeader').forEach(btn => {
        btn.addEventListener('click', e => { e.preventDefault(); openModal(loginModal); });
    });
    qsa('#openRegisterModalBtn, #openRegisterModalBtnMobile, #openRegisterModalBtnMobileHeader').forEach(btn => {
        btn.addEventListener('click', e => { e.preventDefault(); openModal(registerModal); });
    });

    const showRegisterLink = qs('#showRegisterModalLink');
    if (showRegisterLink) {
        showRegisterLink.addEventListener('click', e => { e.preventDefault(); closeModal(loginModal); openModal(registerModal); });
    }
    const showLoginLink = qs('#showLoginModalLink');
    if (showLoginLink) {
        showLoginLink.addEventListener('click', e => { e.preventDefault(); closeModal(registerModal); openModal(loginModal); });
    }

    qsa('.modal-overlay .modal-close-btn').forEach(btn => {
        btn.addEventListener('click', () => closeModal(btn.closest('.modal-overlay')));
    });
    qsa('.modal-overlay').forEach(overlay => {
        overlay.addEventListener('click', e => {
            if (e.target === overlay) closeModal(overlay);
        });
    });

    qsa('.legal-link').forEach(link => {
        link.addEventListener('click', e => {
            e.preventDefault();
            const title = link.getAttribute('data-modal-title') || '';
            const contentId = link.getAttribute('data-modal-content-id');
            const source = contentId ? qs(`#${contentId}`) : null;
            if (!source) return;
            const modalTitle = qs('#modalTitle', legalModal);
            const modalBody = qs('#modalBody', legalModal);
            if (modalTitle) modalTitle.textContent = title;
            if (modalBody) modalBody.innerHTML = source.innerHTML;
            openModal(legalModal);
        });
    });
})();
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
  var hamburger = document.getElementById('mainHamburger');
  var mainMenu = hamburger.closest('.main-menu');
  hamburger.addEventListener('click', function() {
    mainMenu.classList.toggle('open');
  });
  // Optional: close menu when clicking outside
  document.addEventListener('click', function(e) {
    if (!mainMenu.contains(e.target) && mainMenu.classList.contains('open')) {
      mainMenu.classList.remove('open');
    }
  });
});
</script>

<style>
@media (max-width: 991.98px) {
  .main-menu nav ul {
    display: none !important;
    position: absolute;
    top: 48px;
    right: 0;
    width: 180px;
    background: #fff;
    box-shadow: 0 4px 24px rgba(0,0,0,0.08);
    flex-direction: column !important;
    padding: 12px 0;
    z-index: 1000;
    border-radius: 12px;
    gap: 0;
  }
  .main-menu.open nav ul {
    display: flex !important;
  }
  .main-menu nav ul li {
    width: 100%;
    margin: 0;
    padding: 0;
    border-bottom: 1px solid #f2f2f2;
  }
  .main-menu nav ul li:last-child {
    border-bottom: none;
  }
  .main-menu nav ul li a {
    display: block;
    width: 100%;
    padding: 14px 24px;
    color: #F56289 !important;
    font-weight: 600;
    text-align: left;
    background: none;
    border-radius: 0;
  }
  .hamburger {
    display: flex !important;
    margin-left: 12px;
    margin-right: 0;
    z-index: 1200;
  }
  .hamburger span {
    background: #F56289 !important;
  }
}
</style>

</body>
</html>
