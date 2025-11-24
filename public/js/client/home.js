// JS extracted from resources/views/Client/home.blade.php
document.addEventListener('DOMContentLoaded', function() {
    // Video visibility observer: play when visible, pause when not
    try {
        const video = document.getElementById('scroll-play-video');
        if (video) {
            const observer = new IntersectionObserver((entries) => {
                const entry = entries[0];
                if (entry && entry.isIntersecting) {
                    video.play();
                } else {
                    video.pause();
                }
            }, { threshold: 0.5 });
            observer.observe(video);
        }
    } catch (e) {
        // fail silently
        console.error && console.error('home.js video observer error', e);
    }

    // Hide navbar at top, show when scrolling down
    try {
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
    } catch (e) {
        console.error && console.error('home.js header scroll error', e);
    }
});

// Force reload on browser back navigation to prevent showing cached logged-in page
window.addEventListener('pageshow', function(event) {
    if (event.persisted) {
        window.location.reload();
    }
});

// Handle promo claiming with login check
function handleClaimPromo(promoCode, promoId) {
    if (!confirm('Are you sure you want to claim this promo? You can only claim it once.')) {
        return;
    }

    fetch(`/client/promo/${promoId}/claim`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(`Promo claimed successfully! Use code: ${promoCode}`);
            location.reload();
        } else {
            alert(data.message || 'Failed to claim promo');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while claiming the promo');
    });
}
