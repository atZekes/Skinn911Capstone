// JS extracted from resources/views/layouts/clientapp.blade.php
document.addEventListener('DOMContentLoaded', function() {
    // Mobile drawer elements
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const mobileDrawer = document.getElementById('mobileDrawer');
    const mobileOverlay = document.getElementById('mobileOverlay');

    // Open mobile drawer
    function openDrawer() {
        if (mobileDrawer && mobileOverlay) {
            mobileDrawer.classList.add('active');
            mobileOverlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    }

    // Close mobile drawer
    function closeDrawer() {
        if (mobileDrawer && mobileOverlay) {
            mobileDrawer.classList.remove('active');
            mobileOverlay.classList.remove('active');
            document.body.style.overflow = '';
        }
    }

    // Event listeners
    if (mobileMenuBtn) {
        mobileMenuBtn.addEventListener('click', openDrawer);
    }

    if (mobileOverlay) {
        mobileOverlay.addEventListener('click', closeDrawer);
    }

    // Close drawer on window resize if viewport becomes desktop size
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 992) {
            closeDrawer();
        }
    });
});
