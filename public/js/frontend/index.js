// Per-view index JS

document.addEventListener("DOMContentLoaded", function() {
    // Video play/pause based on visibility
    const video = document.getElementById('scroll-play-video');
    if (video) {
        const observer = new IntersectionObserver((entries) => {
            const entry = entries[0];
            if (entry.isIntersecting) {
                video.play();
            } else {
                video.pause();
            }
        }, { threshold: 0.5 });
        observer.observe(video);
    }

    // Sticky header handling
    (function() {
        var header = document.querySelector('.header-area');
        var mainHeader = document.querySelector('.main-header-area');
        function handleScroll() {
            if (window.scrollY > 50) {
                if (header) header.style.display = '';
                if (mainHeader) mainHeader.classList.add('sticky');
            } else {
                if (header) header.style.display = 'none';
                if (mainHeader) mainHeader.classList.remove('sticky');
            }
        }
        handleScroll();
        window.addEventListener('scroll', handleScroll);
    })();
});

// Force reload on browser back navigation to prevent showing cached logged-in page
window.addEventListener('pageshow', function(event) {
    if (event.persisted) {
        window.location.reload();
    }
});
