/* ===================================================================
   MODERN CLIENT APP NAVIGATION - SKIN911
   Premium JavaScript for Enhanced User Experience
   =================================================================== */

document.addEventListener('DOMContentLoaded', function() {
    console.log('✨ Modern ClientApp Navigation Loaded');

    // ================================================================
    // MOBILE DRAWER FUNCTIONALITY
    // ================================================================
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const mobileDrawer = document.getElementById('mobileDrawer');
    const mobileOverlay = document.getElementById('mobileOverlay');

    // Open mobile drawer
    function openDrawer() {
        if (mobileDrawer && mobileOverlay && mobileMenuBtn) {
            mobileDrawer.classList.add('active');
            mobileOverlay.classList.add('active');
            mobileMenuBtn.classList.add('active');
            document.body.classList.add('drawer-open');
            document.body.style.overflow = 'hidden';
            console.log('📱 Mobile drawer opened');
        }
    }

    // Close mobile drawer
    function closeDrawer() {
        if (mobileDrawer && mobileOverlay && mobileMenuBtn) {
            mobileDrawer.classList.remove('active');
            mobileOverlay.classList.remove('active');
            mobileMenuBtn.classList.remove('active');
            document.body.classList.remove('drawer-open');
            document.body.style.overflow = '';
            console.log('📱 Mobile drawer closed');
        }
    }

    // Toggle drawer
    function toggleDrawer() {
        if (mobileDrawer && mobileDrawer.classList.contains('active')) {
            closeDrawer();
        } else {
            openDrawer();
        }
    }

    // Event Listeners
    if (mobileMenuBtn) {
        mobileMenuBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            toggleDrawer();
        });
    }

    if (mobileOverlay) {
        mobileOverlay.addEventListener('click', closeDrawer);
    }

    // Close drawer when clicking on a nav link or profile link
    const mobileNavLinks = document.querySelectorAll('.mobile-nav-link');
    const mobileProfileLink = document.querySelector('.mobile-user-profile-link');

    mobileNavLinks.forEach(link => {
        link.addEventListener('click', function() {
            // Small delay to show the click animation
            setTimeout(closeDrawer, 200);
        });
    });

    if (mobileProfileLink) {
        mobileProfileLink.addEventListener('click', function() {
            // Small delay to show the click animation
            setTimeout(closeDrawer, 200);
        });
    }

    // Close drawer on window resize if viewport becomes desktop size
    let resizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            if (window.innerWidth >= 992) {
                closeDrawer();
            }
        }, 250);
    });

    // Close drawer on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && mobileDrawer && mobileDrawer.classList.contains('active')) {
            closeDrawer();
        }
    });

    // ================================================================
    // USER PROFILE & LOGOUT - No dropdown needed anymore
    // ================================================================
    // Profile button is now a direct link to edit profile page
    // Logout button submits the logout form directly
    console.log('✅ User menu simplified - no dropdown needed');

    // ================================================================
    // HEADER SCROLL EFFECT
    // ================================================================
    const header = document.querySelector('.modern-header');
    let lastScrollTop = 0;
    let scrollThreshold = 20;

    function handleScroll() {
        if (!header) return;

        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

        // Add shadow when scrolled down
        if (scrollTop > scrollThreshold) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }

        lastScrollTop = scrollTop;
    }

    // Throttled scroll event
    let scrollTimer;
    window.addEventListener('scroll', function() {
        if (scrollTimer) {
            window.cancelAnimationFrame(scrollTimer);
        }
        scrollTimer = window.requestAnimationFrame(handleScroll);
    }, { passive: true });

    // Initial check
    handleScroll();

    // ================================================================
    // ACTIVE NAVIGATION LINK HIGHLIGHTING
    // ================================================================
    const currentPath = window.location.pathname;
    const navLinks = document.querySelectorAll('.nav-link, .mobile-nav-link');

    navLinks.forEach(link => {
        const href = link.getAttribute('href');
        if (href && currentPath.includes(href) && href !== '/') {
            link.classList.add('active');
        }
    });

    // ================================================================
    // SMOOTH TRANSITIONS
    // ================================================================
    // Prevent FOUC (Flash of Unstyled Content)
    setTimeout(function() {
        document.body.classList.add('loaded');
    }, 100);

    // ================================================================
    // ACCESSIBILITY ENHANCEMENTS
    // ================================================================

    // Focus trap for mobile drawer
    function trapFocus(element) {
        const focusableElements = element.querySelectorAll(
            'a[href], button:not([disabled]), textarea, input, select'
        );
        const firstFocusable = focusableElements[0];
        const lastFocusable = focusableElements[focusableElements.length - 1];

        element.addEventListener('keydown', function(e) {
            if (e.key === 'Tab') {
                if (e.shiftKey) {
                    if (document.activeElement === firstFocusable) {
                        lastFocusable.focus();
                        e.preventDefault();
                    }
                } else {
                    if (document.activeElement === lastFocusable) {
                        firstFocusable.focus();
                        e.preventDefault();
                    }
                }
            }
        });
    }

    if (mobileDrawer) {
        trapFocus(mobileDrawer);
    }

    // ================================================================
    // CONSOLE LOG STYLING
    // ================================================================
    console.log(
        '%c🎨 Skin911 Modern Navigation Initialized! ',
        'background: linear-gradient(135deg, #F56289 0%, #ff8ba7 100%); color: white; padding: 10px 20px; border-radius: 8px; font-weight: bold; font-size: 14px;'
    );
});
