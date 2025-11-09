// Simple, beginner-friendly script for client services page
// Features: category filter, mobile swipe carousel, expand/collapse details

function initSimpleServices() {
  // 1) Filters: show/hide category sections
  var filterButtons = document.querySelectorAll('.filter_btn');
  for (var i = 0; i < filterButtons.length; i++) {
    (function (btn) {
      btn.addEventListener('click', function () {
        // remove active from all buttons
        for (var j = 0; j < filterButtons.length; j++) filterButtons[j].classList.remove('active');
        btn.classList.add('active');
        var cat = btn.getAttribute('data-category');
        var sections = document.querySelectorAll('.category-section');
        for (var k = 0; k < sections.length; k++) {
          var sec = sections[k];
          if (cat === 'all') sec.style.display = '';
          else if (sec.id === cat + '-section') sec.style.display = '';
          else sec.style.display = 'none';
        }
      });
    })(filterButtons[i]);
  }

  // 2) Initialize Owl Carousel for services
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

  // 3) Expand / collapse details
  var expandButtons = document.querySelectorAll('.expand-btn');
  for (var e = 0; e < expandButtons.length; e++) {
    (function (btn) {
      btn.addEventListener('click', function () {
        var card = btn.closest('.service-card');
        var details = card.querySelector('.service-details');
        var info = card.querySelector('.service-info');
        if (details.style.display === 'block') {
          details.style.display = 'none';
          info.style.display = 'block';
          btn.textContent = 'Learn More';
        } else {
          details.style.display = 'block';
          info.style.display = 'none';
          btn.textContent = 'Show Less';
        }
      });
    })(expandButtons[e]);
  }

  // Back buttons inside details
  var backButtons = document.querySelectorAll('.back-btn');
  for (var b = 0; b < backButtons.length; b++) {
    (function (btn) {
      btn.addEventListener('click', function (ev) {
        ev.preventDefault();
        var card = btn.closest('.service-card');
        var details = card.querySelector('.service-details');
        var info = card.querySelector('.service-info');
        details.style.display = 'none';
        info.style.display = 'block';
        var expand = card.querySelector('.expand-btn');
        if (expand) expand.textContent = 'Learn More';
      });
    })(backButtons[b]);
  }
}

// Init once
if (!window.__simpleServicesLoaded) {
  document.addEventListener('DOMContentLoaded', initSimpleServices);
  window.__simpleServicesLoaded = true;
}

// Header sticky behavior to hide carousel arrows
document.addEventListener('DOMContentLoaded', function() {
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
