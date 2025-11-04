// Simple contact page script
document.addEventListener('DOMContentLoaded', function() {
    console.log('Contact page loaded');

    // Elements
    var wrapper = document.querySelector('.custom-select-wrapper');
    var trigger = wrapper ? wrapper.querySelector('.custom-select-trigger') : null;
    var options = wrapper ? wrapper.querySelectorAll('.custom-option') : [];
    var hiddenSelect = document.getElementById('branch-select');

    console.log('Found', options.length, 'branch options');

    // Update the visible info area using data from the option element
    function updateInfo(optionElement) {
        var mapSrc = optionElement.getAttribute('data-map-src') || '';
        var locationDetail = optionElement.getAttribute('data-location-detail') || '';
        var address = optionElement.getAttribute('data-address') || '';
        var hours = optionElement.getAttribute('data-hours') || '';
        var contactNumber = optionElement.getAttribute('data-contact-number') || '';
        var telephoneNumber = optionElement.getAttribute('data-telephone-number') || '';

        console.log('Updating branch:', optionElement.textContent, 'with contact:', contactNumber);

        // Update the page elements
        var map = document.getElementById('map');
        var loc = document.getElementById('branch-location-detail');
        var addr = document.getElementById('branch-address');
        var hoursDiv = document.getElementById('branch-hours');
        var contactDiv = document.getElementById('branch-contact');
        var directionsLink = document.getElementById('get-directions');

        // Update map
        if (map && mapSrc) {
            map.src = mapSrc;
            console.log('Map updated successfully');
        }

        // Update other info
        if (loc) loc.textContent = locationDetail || 'Location details not available';
        if (addr) addr.textContent = address || 'Address not available';

        // Update contact information
        if (contactDiv) {
            var contactText = '';
            if (contactNumber && contactNumber.trim() !== '') {
                contactText += 'Mobile: ' + contactNumber;
            }
            if (telephoneNumber && telephoneNumber.trim() !== '') {
                if (contactText) contactText += '<br>';
                contactText += 'Phone: ' + telephoneNumber;
            }
            if (contactText === '') {
                contactText = 'Contact information coming soon';
            }
            contactDiv.innerHTML = contactText;
        }

        // Update hours with "Coming soon" fallback
        if (hoursDiv) {
            if (hours && hours.trim() !== '') {
                hoursDiv.innerHTML = hours;
            } else {
                hoursDiv.innerHTML = '<div style="color: #888; font-style: italic;">Coming soon</div>';
            }
        }

        // Update directions link
        if (directionsLink && address) {
            // Create Google Maps directions URL
            var directionsUrl = 'https://www.google.com/maps/dir/?api=1&destination=' + encodeURIComponent(address);
            directionsLink.href = directionsUrl;
            directionsLink.target = '_blank'; // Open in new tab
            console.log('Directions URL updated:', directionsUrl);
        }
    }

    // Initialize with first branch on page load
    if (options.length > 0) {
        updateInfo(options[0]);
    }

    // Attach click to trigger to open/close dropdown
    if (trigger && wrapper) {
        trigger.addEventListener('click', function(e) {
            e.stopPropagation();
            wrapper.classList.toggle('open');
        });
    }

    // Attach click to each custom option
    for (var i = 0; i < options.length; i++) {
        (function(opt) {
            opt.addEventListener('click', function() {
                var text = opt.textContent || opt.innerText || '';

                // Update visible trigger text
                if (trigger) {
                    var span = trigger.querySelector('span');
                    if (span) span.textContent = text;
                }

                // Update info display using this option data
                updateInfo(opt);

                // Close dropdown
                if (wrapper) wrapper.classList.remove('open');
            });
        })(options[i]);
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function() {
        if (wrapper) wrapper.classList.remove('open');
    });
});

// Function to open login modal (called by Enquire and Book Now buttons)
function openLoginModal() {
    const loginModal = document.getElementById('loginModal');
    if (loginModal) {
        loginModal.classList.add('active');
        loginModal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    }
}
