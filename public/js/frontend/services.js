// Per-view services JS (copied from public/js/services.js)

// Services page specific JS consolidated

document.addEventListener('DOMContentLoaded', function() {
    // Initialize Owl Carousel for services
    $('.carousel-container').owlCarousel({
        loop: false,
        margin: 32, // Increased margin to match CSS gap
        nav: true,
        navText: ['‹', '›'],
        dots: false,
        responsive: {
            0: {
                items: 1,
                nav: false // Hide nav on mobile
            },
            576: {
                items: 2,
                nav: false // Hide nav on tablet
            },
            768: {
                items: 2,
                nav: true // Show nav on desktop
            },
            992: {
                items: 3,
                nav: true
            },
            1200: {
                items: 4,
                nav: true
            }
        }
    });

    // Function to snap to nearest card (kept for compatibility)
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
    const allCarouselArrows = document.querySelectorAll('.owl-nav button');

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
            // Redirect to booking page with service ID
            window.location.href = '/client/booking?service_id=' + serviceId;
        } else {
            // Show login modal using custom modal system
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
