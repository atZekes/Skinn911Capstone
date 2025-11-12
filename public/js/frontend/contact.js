// Simple contact page script
document.addEventListener('DOMContentLoaded', function() {
    console.log('Contact page loaded');

    // Elements for city filter (explicit wrappers)
    var cityFilterWrapper = document.querySelector('.city-select-wrapper');
    var cityFilterTrigger = cityFilterWrapper ? cityFilterWrapper.querySelector('.custom-select-trigger') : null;
    var cityFilterOptions = cityFilterWrapper ? cityFilterWrapper.querySelectorAll('.custom-option') : [];
    var hiddenCityFilter = document.getElementById('city-filter');

    // Elements for branch selector (explicit wrappers)
    var branchWrapper = document.querySelector('.branch-select-wrapper');
    var branchTrigger = branchWrapper ? branchWrapper.querySelector('.custom-select-trigger') : null;
    var branchOptions = branchWrapper ? branchWrapper.querySelectorAll('.custom-option') : [];
    var hiddenBranchSelect = document.getElementById('branch-select');

    console.log('Found', cityFilterOptions.length, 'city filter options');
    console.log('Found', branchOptions.length, 'branch options');

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
    // Map iframe has id 'branch-map' in the blade template
    var map = document.getElementById('branch-map');
        var mapPlaceholder = document.getElementById('map-placeholder');
        var loc = document.getElementById('branch-location-detail');
        var addr = document.getElementById('branch-address');
        var hoursDiv = document.getElementById('branch-hours');
        var contactDiv = document.getElementById('branch-contact');
        var directionsLink = document.getElementById('get-directions');

        // Update map - show map if mapSrc exists, otherwise show placeholder
        if (map && mapPlaceholder) {
            if (mapSrc && mapSrc.trim() !== '') {
                map.src = mapSrc;
                map.style.display = 'block';
                mapPlaceholder.style.display = 'none';
                console.log('Map updated successfully');
            } else {
                map.style.display = 'none';
                mapPlaceholder.style.display = 'flex';
            }
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

        // Update directions link - show only if map exists
        if (directionsLink) {
            if (mapSrc && mapSrc.trim() !== '' && address) {
                // Create Google Maps directions URL
                var directionsUrl = 'https://www.google.com/maps/dir/?api=1&destination=' + encodeURIComponent(address);
                directionsLink.href = directionsUrl;
                directionsLink.target = '_blank'; // Open in new tab
                directionsLink.style.display = 'block';
                console.log('Directions URL updated:', directionsUrl);
            } else {
                directionsLink.style.display = 'none';
            }
        }
    }

    // Don't initialize on page load - wait for user to select branch
    // Show placeholder initially
    // Initialize map placeholder on load
    var map = document.getElementById('branch-map');
    var mapPlaceholder = document.getElementById('map-placeholder');
    if (map && mapPlaceholder) {
        map.style.display = 'none';
        mapPlaceholder.style.display = 'flex';
    }

    // Attach click to branch trigger to open/close dropdown
    if (branchTrigger && branchWrapper) {
        branchTrigger.addEventListener('click', function(e) {
            e.stopPropagation();
            branchWrapper.classList.toggle('open');
            // Close city filter if open
            if (cityFilterWrapper) cityFilterWrapper.classList.remove('open');
        });
    }

    // Attach click to city filter trigger to open/close dropdown
    if (cityFilterTrigger && cityFilterWrapper) {
        cityFilterTrigger.addEventListener('click', function(e) {
            e.stopPropagation();
            cityFilterWrapper.classList.toggle('open');
            // Close branch selector if open
            if (branchWrapper) branchWrapper.classList.remove('open');
        });
    }

    // Attach click to each branch custom option
    for (var i = 0; i < branchOptions.length; i++) {
        (function(opt) {
            opt.addEventListener('click', function() {
                var text = opt.textContent || opt.innerText || '';
                var value = opt.getAttribute('data-value') || '';

                // Update visible trigger text
                if (branchTrigger) {
                    var span = branchTrigger.querySelector('span');
                    if (span) span.textContent = text;
                }

                // Update hidden select value
                if (hiddenBranchSelect) {
                    hiddenBranchSelect.value = value;
                }

                // Update info display using this option data
                updateInfo(opt);

                // Close dropdown
                if (branchWrapper) branchWrapper.classList.remove('open');
            });
        })(branchOptions[i]);
    }

    // Attach click to each city filter custom option
    for (var i = 0; i < cityFilterOptions.length; i++) {
        (function(opt) {
            opt.addEventListener('click', function() {
                var text = opt.textContent || opt.innerText || '';
                var value = opt.getAttribute('data-value') || '';

                // Update visible trigger text
                if (cityFilterTrigger) {
                    var span = cityFilterTrigger.querySelector('span');
                    if (span) span.textContent = text;
                }

                // Update hidden select value
                if (hiddenCityFilter) {
                    hiddenCityFilter.value = value;
                }

                // Trigger city filter change
                handleCityFilterChange(value);

                // Close dropdown
                if (cityFilterWrapper) cityFilterWrapper.classList.remove('open');
            });
        })(cityFilterOptions[i]);
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function() {
        if (branchWrapper) branchWrapper.classList.remove('open');
        if (cityFilterWrapper) cityFilterWrapper.classList.remove('open');
    });

    // City filter functionality
    function handleCityFilterChange(selectedCity) {
        var customOptions = branchWrapper ? branchWrapper.querySelectorAll('.custom-option') : [];
        var hiddenOptions = hiddenBranchSelect ? hiddenBranchSelect.querySelectorAll('option') : [];

        console.log('Filtering by city:', selectedCity || 'All Cities');

        // Filter custom dropdown options
        customOptions.forEach(function(option) {
            var branchCity = option.getAttribute('data-city') || '';
            if (selectedCity === '' || branchCity === selectedCity) {
                option.style.display = 'block';
            } else {
                option.style.display = 'none';
            }
        });

        // Filter hidden select options
        hiddenOptions.forEach(function(option) {
            if (option.value === '') return; // Keep "Select Branch" option
            var branchCity = option.getAttribute('data-city') || '';
            if (selectedCity === '' || branchCity === selectedCity) {
                option.style.display = '';
            } else {
                option.style.display = 'none';
            }
        });

        // Reset branch selection to "Select Branch"
        if (branchTrigger) {
            var span = branchTrigger.querySelector('span');
            if (span) span.textContent = 'Select Branch';
        }

        // Update hidden select to empty value
        if (hiddenBranchSelect) {
            hiddenBranchSelect.value = '';
        }

        // Hide map and show placeholder
        var map = document.getElementById('branch-map');
        var mapPlaceholder = document.getElementById('map-placeholder');
        if (map) {
            map.style.display = 'none';
            map.src = '';
        }
        if (mapPlaceholder) {
            mapPlaceholder.style.display = 'flex';
        }

        // Hide directions button
        var directionsLink = document.getElementById('get-directions');
        if (directionsLink) {
            directionsLink.style.display = 'none';
        }

        // Clear branch information
        var loc = document.getElementById('branch-location-detail');
        var addr = document.getElementById('branch-address');
        var hoursDiv = document.getElementById('branch-hours');
        var contactDiv = document.getElementById('branch-contact');

        if (loc) loc.textContent = '';
        if (addr) addr.textContent = '';
        if (hoursDiv) hoursDiv.innerHTML = '';
        if (contactDiv) contactDiv.innerHTML = 'Contact information coming soon';
    }
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
