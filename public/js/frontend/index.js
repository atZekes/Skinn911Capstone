// Per-view index JS

document.addEventListener("DOMContentLoaded", function() {
    // Video play/pause based on visibility with responsive behavior
    const video = document.getElementById('scroll-play-video');
    if (video) {
        let isPlaying = false;

        // Function to detect device type
        function getDeviceType() {
            const width = window.innerWidth;
            if (width <= 767) return 'mobile';
            if (width <= 1199) return 'tablet';
            return 'desktop';
        }

        // Function to get device-specific settings
        function getDeviceSettings(deviceType) {
            switch (deviceType) {
                case 'mobile':
                    return {
                        threshold: 0.8, // Need 80% visible on mobile (more conservative)
                        enableAutoplay: false, // Disable autoplay on mobile to save data
                        playOnScroll: true // But allow manual play when scrolled into view
                    };
                case 'tablet':
                    return {
                        threshold: 0.6, // Need 60% visible on tablet
                        enableAutoplay: true,
                        playOnScroll: true
                    };
                case 'desktop':
                default:
                    return {
                        threshold: 0.5, // Need 50% visible on desktop
                        enableAutoplay: true,
                        playOnScroll: true
                    };
            }
        }

        let currentDeviceType = getDeviceType();
        let settings = getDeviceSettings(currentDeviceType);

        // Create intersection observer with device-specific settings
        let observer = new IntersectionObserver((entries) => {
            const entry = entries[0];
            const shouldPlay = entry.isIntersecting && !isPlaying && settings.playOnScroll;
            const shouldPause = !entry.isIntersecting && isPlaying;

            if (shouldPlay) {
                // Video is in view and not already playing
                const playPromise = video.play();
                if (playPromise !== undefined) {
                    playPromise.then(() => {
                        isPlaying = true;
                    }).catch(error => {
                        // Silently handle autoplay policy errors or abort errors
                        if (error.name !== 'AbortError') {
                            console.warn('Video play failed:', error);
                        }
                    });
                }
            } else if (shouldPause) {
                // Video is out of view and currently playing
                video.pause();
                isPlaying = false;
            }
        }, { threshold: settings.threshold });

        observer.observe(video);

        // Handle window resize to update device type and settings
        window.addEventListener('resize', () => {
            const newDeviceType = getDeviceType();
            if (newDeviceType !== currentDeviceType) {
                currentDeviceType = newDeviceType;
                settings = getDeviceSettings(currentDeviceType);

                // Disconnect old observer and create new one with updated settings
                observer.disconnect();
                observer = new IntersectionObserver((entries) => {
                    const entry = entries[0];
                    const shouldPlay = entry.isIntersecting && !isPlaying && settings.playOnScroll;
                    const shouldPause = !entry.isIntersecting && isPlaying;

                    if (shouldPlay) {
                        const playPromise = video.play();
                        if (playPromise !== undefined) {
                            playPromise.then(() => {
                                isPlaying = true;
                            }).catch(error => {
                                if (error.name !== 'AbortError') {
                                    console.warn('Video play failed:', error);
                                }
                            });
                        }
                    } else if (shouldPause) {
                        video.pause();
                        isPlaying = false;
                    }
                }, { threshold: settings.threshold });

                observer.observe(video);
            }
        });
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

// Handle offer image clicks - redirect to booking if logged in, show login modal if not
const offerImages = document.querySelectorAll('.single_offers .about_thumb img');
offerImages.forEach(img => {
    img.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();

        if (window.isAuthenticated) {
            // User is logged in, redirect to booking page
            window.location.href = '/client/booking';
        } else {
            // User is not logged in, show login modal
            const loginBtn = document.getElementById('openLoginModalBtn');
            if (loginBtn) {
                loginBtn.click();
            }
        }
    });
});

// Handle featured service image clicks - redirect to booking if logged in, show login modal if not
const featuredServiceImages = document.querySelectorAll('.single_rooms .room_thumb img');
featuredServiceImages.forEach(img => {
    img.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();

        if (window.isAuthenticated) {
            // User is logged in, redirect to booking page
            window.location.href = '/client/booking';
        } else {
            // User is not logged in, show login modal
            const loginBtn = document.getElementById('openLoginModalBtn');
            if (loginBtn) {
                loginBtn.click();
            }
        }
    });
});

// Force reload on browser back navigation to prevent showing cached logged-in page
window.addEventListener('pageshow', function(event) {
    if (event.persisted) {
        window.location.reload();
    }
});
