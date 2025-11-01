// Simple Header JavaScript - Easy to understand mobile menu
// This handles opening and closing the mobile menu

document.addEventListener('DOMContentLoaded', function() {
    // Get the important elements we need
    var mobileMenuButton = document.getElementById('clientHamburger');
    var mobileMenu = document.getElementById('clientDrawer');
    var mobileOverlay = document.getElementById('drawerBackdrop');

    // Check if elements exist before using them
    if (!mobileMenuButton || !mobileMenu || !mobileOverlay) {
        console.log('Mobile menu elements not found');
        return;
    }

    // Function to open the mobile menu
    function openMobileMenu() {
        mobileMenu.classList.add('show');
        mobileOverlay.classList.add('show');
        document.body.style.overflow = 'hidden'; // Prevent scrolling
    }

    // Function to close the mobile menu
    function closeMobileMenu() {
        mobileMenu.classList.remove('show');
        mobileOverlay.classList.remove('show');
        document.body.style.overflow = 'auto'; // Allow scrolling again
    }

    // When user clicks the hamburger button, open menu
    mobileMenuButton.addEventListener('click', function() {
        openMobileMenu();
    });

    // When user clicks the overlay (dark area), close menu
    mobileOverlay.addEventListener('click', function() {
        closeMobileMenu();
    });

    // Close menu when window is resized to desktop size
    window.addEventListener('resize', function() {
        if (window.innerWidth > 991) {
            closeMobileMenu();
        }
    });
});
