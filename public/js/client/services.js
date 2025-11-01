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

  // 2) Carousels: DISABLED custom touch handlers - using native browser scrolling instead
  // Native scrolling works better and is more reliable
  var carousels = document.querySelectorAll('.services-carousel .carousel-container');
  // No touch handlers - browser handles all scrolling natively

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
