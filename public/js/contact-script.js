// Wait for the HTML document to be fully loaded before running the script
document.addEventListener('DOMContentLoaded', function () {

    // =================================================================
    //  STEP A: ADD ALL YOUR BRANCH INFORMATION HERE
    // =================================================================
    // This is the only place you need to add or edit branch details.
    //
    // How to add a new branch:
    // 1. Copy one of the existing blocks (like the 'banilad' block).
    // 2. Paste it at the end, inside the `branchData` object.
    // 3. Give it a unique key (e.g., 'smcebu'). This key MUST match the `value` in the HTML dropdown option.
    // 4. Update all the details: mapSrc, locationDetail, address, and hours.
    //
    const branchData = {
        'banilad': {
            mapSrc: 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3925.338164057885!2d123.9113623758838!3d10.33446006579626!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33a998e1f579c09d%3A0x868685714792f442!2sBanilad%20Town%20Centre!5e0!3m2!1sen!2sph!4v1678886478901!5m2!1sen!2sph',
            locationDetail: '(2nd level of Banilad Town Centre)',
            address: '2nd Level, Banilad Town Centre, Gov. M. Cuenco Ave., Cebu City',
            hours: `<div><span><strong>Mon</strong></span><br><span><strong>Tue - Sun</strong></span></div><div><span>Closed</span><br><span>10:00 am - 07:30 pm</span></div>`
        },
        'ayala': {
            mapSrc: 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3925.393439498145!2d123.90333867588377!3d10.32997976585148!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33a9992015555555%3A0x153298416d823681!2sAyala%20Center%2C%20Cebu!5e0!3m2!1sen!2sph!4v1678887123456!5m2!1sen!2sph',
            locationDetail: '(Ayala Center Cebu)',
            address: 'Archbishop Reyes Ave, Cebu City, 6000 Cebu',
            hours: `<div><span><strong>Mon - Sun</strong></span></div><div><span>10:00 am - 09:00 pm</span></div>`
        },
        'vrama': {
            mapSrc: 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3925.66693574932!2d123.8860074758835!3d10.30739946609938!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33a99955776a3103%3A0x28945a1f4965c401!2s2211%20V%20Rama%20Ave%2C%20Cebu%20City%2C%20Cebu!5e0!3m2!1sen!2sph!4v1678887234567!5m2!1sen!2sph',
            locationDetail: '(V. Rama Avenue)',
            address: '2211 V. Rama Ave, Cebu City, Cebu',
            hours: `<div><span><strong>Mon - Sat</strong></span><br><span><strong>Sun</strong></span></div><div><span>9:00 am - 6:00 pm</span><br><span>Closed</span></div>`
        },
        // --- EXAMPLE OF A NEW BRANCH ---
        'smcebu': {
            mapSrc: 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3925.434823483981!2d123.9161218758837!3d10.326758865882885!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33a999212456102b%3A0x6318371832222853!2sSM%20City%20Cebu!5e0!3m2!1sen!2sph!4v1678887345678!5m2!1sen!2sph',
            locationDetail: '(SM City Cebu)',
            address: 'Juan Luna Ave. corner Cabahug and Kaohsiung St., North Reclamation Area, Cebu City',
            hours: `<div><span><strong>Mon - Sun</strong></span></div><div><span>10:00 am - 10:00 pm</span></div>`
        }
        // --- ADD MORE BRANCHES HERE ---
    };

    // =================================================================
    //  DO NOT EDIT THE CODE BELOW THIS LINE
    // =================================================================
    const branchSelect = document.getElementById('branch-select');
    
    // Check if the dropdown element actually exists on the page
    if (branchSelect) {
        // Function to update the displayed info based on the selected branch
        function updateBranchInfo(branchKey) {
            const data = branchData[branchKey];
            if (!data) {
                console.error("No data found for branch key:", branchKey);
                return;
            }

            // Get all the elements we need to update
            const mapFrame = document.getElementById('branch-map');
            const locationDetailEl = document.getElementById('branch-location-detail');
            const addressEl = document.getElementById('branch-address');
            const hoursEl = document.getElementById('branch-hours');

            // Update the content of each element
            if (mapFrame) mapFrame.src = data.mapSrc;
            if (locationDetailEl) locationDetailEl.textContent = data.locationDetail;
            if (addressEl) addressEl.textContent = data.address;
            if (hoursEl) hoursEl.innerHTML = data.hours;
        }
        
        // Listen for any change in the dropdown menu
        branchSelect.addEventListener('change', function() {
            updateBranchInfo(this.value);
        });

        // Load the details for the default selected branch when the page first loads
        updateBranchInfo(branchSelect.value);
    }
});