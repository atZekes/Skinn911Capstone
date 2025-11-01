// Services page specific JS consolidated

document.addEventListener('DOMContentLoaded', function() {
    // Carousel functionality
    const carousels = document.querySelectorAll('.services-carousel');

    carousels.forEach(carousel => {
        const container = carousel.querySelector('.carousel-container');
        const prevBtn = carousel.querySelector('.prev');
        const nextBtn = carousel.querySelector('.next');
        const cards = carousel.querySelectorAll('.service-card');

        let currentIndex = 0;
        const cardWidth = 320; // Width of each card + margin
        const visibleCards = Math.floor(container.offsetWidth / cardWidth);
        const maxIndex = Math.max(0, cards.length - visibleCards);

        function updateCarousel() {
            const translateX = -currentIndex * cardWidth;
            container.style.transform = `translateX(${translateX}px)`;
            if (prevBtn) prevBtn.style.display = currentIndex === 0 ? 'none' : 'block';
            if (nextBtn) nextBtn.style.display = currentIndex >= maxIndex ? 'none' : 'block';
        }

        if (prevBtn && nextBtn) {
            prevBtn.addEventListener('click', () => {
                if (currentIndex > 0) { currentIndex--; updateCarousel(); }
            });
            nextBtn.addEventListener('click', () => {
                if (currentIndex < maxIndex) { currentIndex++; updateCarousel(); }
            });
        }
        updateCarousel();
    });

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

    // Enable touch swipe for carousel on mobile
    document.querySelectorAll('.carousel-container').forEach(function(container) {
        let startX = 0;
        let currentTranslate = 0;
        let isDragging = false;
        let currentIndex = 0;
        container.addEventListener('touchstart', function(e) {
            isDragging = true;
            startX = e.touches[0].clientX;
            currentTranslate = getTranslateX(container);
        });
        container.addEventListener('touchmove', function(e) {
            if (!isDragging) return;
            let deltaX = e.touches[0].clientX - startX;
            container.style.transition = 'none';
            container.style.transform = `translateX(${currentTranslate + deltaX}px)`;
        });
        container.addEventListener('touchend', function(e) {
            isDragging = false;
            container.style.transition = '';
            let deltaX = e.changedTouches[0].clientX - startX;
            let cardWidth = container.querySelector('.service-card').offsetWidth + 24;
            let visibleCards = Math.floor(container.offsetWidth / cardWidth) || 1;
            let maxIndex = Math.max(0, container.querySelectorAll('.service-card').length - visibleCards);
            currentIndex = Math.round(-getTranslateX(container) / cardWidth);
            if (deltaX < -50 && currentIndex < maxIndex) currentIndex++;
            if (deltaX > 50 && currentIndex > 0) currentIndex--;
            currentIndex = Math.max(0, Math.min(currentIndex, maxIndex));
            container.style.transform = `translateX(${-currentIndex * cardWidth}px)`;
        });
        function getTranslateX(el) {
            const style = window.getComputedStyle(el);
            const matrix = new WebKitCSSMatrix(style.transform);
            return matrix.m41;
        }
    });
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
