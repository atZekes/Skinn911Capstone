// Per-view services JS (copied from public/js/services.js)

// Services page specific JS consolidated

document.addEventListener('DOMContentLoaded', function() {
    // Carousel functionality: native horizontal scroll with drag-to-scroll
    const carousels = document.querySelectorAll('.services-carousel');

    carousels.forEach(carousel => {
        const container = carousel.querySelector('.carousel-container');
        if (!container) return;

        // Mouse drag / touch drag
        let isDown = false;
        let startX;
        let scrollLeftStart;

        container.addEventListener('mousedown', (e) => {
            isDown = true;
            container.classList.add('is-dragging');
            startX = e.pageX - container.offsetLeft;
            scrollLeftStart = container.scrollLeft;
        });
        container.addEventListener('mouseleave', () => {
            isDown = false;
            container.classList.remove('is-dragging');
        });
        container.addEventListener('mouseup', () => {
            isDown = false;
            container.classList.remove('is-dragging');
            snapToNearestCard(container);
        });
        container.addEventListener('mousemove', (e) => {
            if (!isDown) return;
            e.preventDefault();
            const x = e.pageX - container.offsetLeft;
            const walk = (x - startX) * 1; // scroll-fast factor
            container.scrollLeft = scrollLeftStart - walk;
        });

        // Touch
        container.addEventListener('touchstart', (e) => {
            startX = e.touches[0].pageX - container.offsetLeft;
            scrollLeftStart = container.scrollLeft;
        });
        container.addEventListener('touchend', () => snapToNearestCard(container));
        container.addEventListener('touchmove', (e) => {
            const x = e.touches[0].pageX - container.offsetLeft;
            const walk = (x - startX) * 1;
            container.scrollLeft = scrollLeftStart - walk;
        });
    });

    function snapToNearestCard(container) {
        const card = container.querySelector('.service-card');
        if (!card) return;
        const cardWidth = card.offsetWidth + parseInt(getComputedStyle(container).gap || 24);
        const index = Math.round(container.scrollLeft / cardWidth);
        container.scrollTo({ left: index * cardWidth, behavior: 'smooth' });
    }

    // Expandable service cards
    const expandBtns = document.querySelectorAll('.expand-btn');
    const backBtns = document.querySelectorAll('.back-btn');

    expandBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const serviceCard = this.closest('.service-card');
            const serviceDetails = serviceCard.querySelector('.service-details');
            const serviceInfo = serviceCard.querySelector('.service-info');

            if (serviceDetails.classList.contains('expanded')) {
                serviceDetails.classList.remove('expanded');
                serviceInfo.style.display = 'block';
                this.textContent = 'Learn More';
            } else {
                serviceDetails.classList.add('expanded');
                serviceInfo.style.display = 'none';
                this.textContent = 'Show Less';
            }
        });
    });

    backBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const serviceCard = this.closest('.service-card');
            const serviceDetails = serviceCard.querySelector('.service-details');
            const serviceInfo = serviceCard.querySelector('.service-info');
            const expandBtn = serviceCard.querySelector('.expand-btn');

            serviceDetails.classList.remove('expanded');
            serviceInfo.style.display = 'block';
            expandBtn.textContent = 'Learn More';
        });
    });

    // Smooth scrolling to sections
    const filterBtns = document.querySelectorAll('.filter_btn');

    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const category = this.getAttribute('data-category');
            if (category !== 'all') {
                const section = document.getElementById(`${category}-section`);
                if (section) {
                    section.scrollIntoView({ behavior: 'smooth' });
                }
            }
        });
    });


    // HIDE CAROUSEL ARROWS WHEN HEADER IS STICKY
    const header = document.querySelector('.main-header-area');
    const allCarouselArrows = document.querySelectorAll('.carousel-nav');

    if (header && allCarouselArrows.length > 0) {

        function toggleArrowVisibility() {
            const isSticky = header.classList.contains('sticky');
            allCarouselArrows.forEach(arrow => {
                if (isSticky) {
                    arrow.classList.add('is-hidden-by-header');
                } else {
                    arrow.classList.remove('is-hidden-by-header');
                }
            });
        }

        window.addEventListener('scroll', toggleArrowVisibility);
        toggleArrowVisibility();
    }

    // Simple touch-to-scroll for mobile (left/right swipe)
    var isMobile = window.matchMedia('(max-width: 767px)').matches;
    if (isMobile) {
        // hide carousel arrows on mobile for cleaner UX
        document.querySelectorAll('.carousel-nav').forEach(function(arrow) {
            arrow.style.display = 'none';
        });

        document.querySelectorAll('.carousel-container').forEach(function(container) {
            var startX = 0;
            var startScrollLeft = 0;

            container.addEventListener('touchstart', function(e) {
                // record start positions
                startX = e.touches[0].pageX;
                startScrollLeft = container.scrollLeft;
            }, { passive: true });

            container.addEventListener('touchmove', function(e) {
                // move the scroll based on finger movement
                var x = e.touches[0].pageX;
                var walk = startX - x; // positive when swiping left
                container.scrollLeft = startScrollLeft + walk;
            }, { passive: true });

            container.addEventListener('touchend', function(e) {
                // snap to nearest card after touch ends
                snapToNearestCard(container);
            });
        });
    }
});

// Booking button functionality
const bookNowBtns = document.querySelectorAll('.book-now-btn');
// default will be overridden inline in the page
window.isLoggedIn = window.isLoggedIn || false;

bookNowBtns.forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        const serviceId = this.getAttribute('data-service-id');

        if (window.isLoggedIn) {
            alert('You are logged in! Booking service ID: ' + serviceId);
        } else {
            const loginModal = document.getElementById('loginModal');
            if (loginModal) {
                loginModal.classList.add('active');
                loginModal.setAttribute('aria-hidden', 'false');
                document.body.style.overflow = 'hidden';
            }
        }
    });
});

// Header sticky behavior (lightweight guard if not present elsewhere)
window.addEventListener('DOMContentLoaded', function() {
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
});
