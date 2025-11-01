// CEO App Layout JavaScript - Mobile Menu Functionality
document.addEventListener('DOMContentLoaded', function() {
    // Get elements for mobile menu
    const mobileMenuToggle = document.getElementById('mobileMenuToggle');
    const ceoSidebar = document.getElementById('ceoSidebar');
    const mobileOverlay = document.getElementById('mobileOverlay');

    // Function to open mobile menu
    function openMobileMenu() {
        console.log('Opening mobile menu');
        if (ceoSidebar) ceoSidebar.classList.add('mobile-open');
        if (mobileOverlay) mobileOverlay.classList.add('active');
        if (mobileMenuToggle) mobileMenuToggle.classList.add('menu-open');

        // Change icon to close icon
        const icon = mobileMenuToggle ? mobileMenuToggle.querySelector('i') : null;
        if (icon) {
            icon.className = 'fas fa-times';
        }

        // Prevent body scroll when menu is open
        document.body.style.overflow = 'hidden';
    }

    // Function to close mobile menu
    function closeMobileMenu() {
        console.log('Closing mobile menu');
        if (ceoSidebar) ceoSidebar.classList.remove('mobile-open');
        if (mobileOverlay) mobileOverlay.classList.remove('active');
        if (mobileMenuToggle) mobileMenuToggle.classList.remove('menu-open');

        // Change icon back to hamburger
        const icon = mobileMenuToggle ? mobileMenuToggle.querySelector('i') : null;
        if (icon) {
            icon.className = 'fas fa-bars';
        }

        // Restore body scroll
        document.body.style.overflow = '';
    }

    // Toggle menu when button is clicked
    if (mobileMenuToggle) {
        mobileMenuToggle.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Menu toggle clicked');
            if (ceoSidebar && ceoSidebar.classList.contains('mobile-open')) {
                closeMobileMenu();
            } else {
                openMobileMenu();
            }
        });
    }

    // Close menu when overlay is clicked
    if (mobileOverlay) {
        mobileOverlay.addEventListener('click', function() {
            closeMobileMenu();
        });
    }

    // Close menu when a nav link is clicked (on mobile)
    const navLinks = document.querySelectorAll('.ceo-tab');
    navLinks.forEach(function(link) {
        link.addEventListener('click', function() {
            // Only close on mobile screens
            if (window.innerWidth <= 768) {
                setTimeout(closeMobileMenu, 200); // Small delay for better UX
            }
        });
    });

    // Handle window resize - close menu if screen gets bigger
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            closeMobileMenu();
        }
    });

    // Handle escape key to close menu
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && ceoSidebar && ceoSidebar.classList.contains('mobile-open')) {
            closeMobileMenu();
        }
    });

    // Add swipe gesture support for closing menu
    let startX = null;
    let startY = null;
    let isSwipeEnabled = true;

    if (ceoSidebar) {
        // Enhanced touch handling for mobile
        ceoSidebar.addEventListener('touchstart', function(e) {
            startX = e.touches[0].clientX;
            startY = e.touches[0].clientY;
            isSwipeEnabled = true;
        }, { passive: true });

        ceoSidebar.addEventListener('touchmove', function(e) {
            if (!startX || !startY || !isSwipeEnabled) return;

            const currentX = e.touches[0].clientX;
            const currentY = e.touches[0].clientY;

            const diffX = startX - currentX;
            const diffY = startY - currentY;

            // If vertical scroll is detected, disable swipe
            if (Math.abs(diffY) > Math.abs(diffX)) {
                isSwipeEnabled = false;
                return;
            }

            // If swiping left significantly and menu is open, close it
            if (Math.abs(diffX) > Math.abs(diffY) && diffX > 80) {
                if (ceoSidebar.classList.contains('mobile-open')) {
                    closeMobileMenu();
                }
            }
        }, { passive: true });

        ceoSidebar.addEventListener('touchend', function() {
            startX = null;
            startY = null;
            isSwipeEnabled = true;
        }, { passive: true });
    }

    // Add edge swipe to open menu (swipe from left edge)
    let edgeSwipeStartX = null;

    document.addEventListener('touchstart', function(e) {
        if (window.innerWidth <= 768 && e.touches[0].clientX < 20) {
            edgeSwipeStartX = e.touches[0].clientX;
        }
    }, { passive: true });

    document.addEventListener('touchmove', function(e) {
        if (edgeSwipeStartX !== null && window.innerWidth <= 768) {
            const currentX = e.touches[0].clientX;
            const diffX = currentX - edgeSwipeStartX;

            // If swiping right from edge and menu is closed, open it
            if (diffX > 50 && !ceoSidebar.classList.contains('mobile-open')) {
                openMobileMenu();
                edgeSwipeStartX = null;
            }
        }
    }, { passive: true });

    document.addEventListener('touchend', function() {
        edgeSwipeStartX = null;
    }, { passive: true });

    // Expose functions globally for potential external use
    window.CEOLayout = {
        openMobileMenu: openMobileMenu,
        closeMobileMenu: closeMobileMenu
    };
});
