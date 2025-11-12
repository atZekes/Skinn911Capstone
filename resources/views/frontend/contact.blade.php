@extends('layouts.app')
@section('content')
@section('hide_layout_banner')@endsection
    <!-- Responsive Banner -->

    <!-- per-view index styles -->
    <link rel="stylesheet" href="{{ asset('css/frontend/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/client/booking.css') }}">

    <!-- slider_area_start -->
    <div class="slider_area">
        <div class="slider_active owl-carousel">
            <div class="single_slider d-flex align-items-center justify-content-center slider-bg-1">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="text-center slider_text">
                                <!-- Add content for first slide if needed -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="single_slider d-flex align-items-center justify-content-center slider-bg-2">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="text-center slider_text">
                                <!-- Add content for second slide if needed -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- slider_area_end -->

<div class="contact-page-wrapper">
    <div class="background-container">
        <div class="contact-card">
            <div class="map-container">
                <!-- Map placeholder - will be shown when no branch is selected -->
               <div id="map-wrapper" style="position: relative; min-height: 500px;">
                    <!-- Placeholder when no branch selected -->
                    <div id="map-placeholder" style="display: flex; align-items: center; justify-content: center; min-height: 500px; background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); border-radius: 14px; text-align: center; box-shadow: 0 4px 24px rgba(0,0,0,0.10);">
                        <div style="padding: 40px;">
                            <i class="fas fa-map-marked-alt" style="font-size: 64px; color: #F56289; margin-bottom: 20px;"></i>
                            <h3 style="color: #333; margin-bottom: 10px;">No Branch Selected</h3>
                            <p style="color: #666; font-size: 16px;">Please select a branch below to view its location on the map</p>
                        </div>
                    </div>
                    <!-- Actual Map -->
                    <iframe id="branch-map" src="" width="100%" height="500" style="display: none; border:0;border-radius:14px;min-height:400px;max-width:1000px;margin:auto;box-shadow:0 4px 24px rgba(0,0,0,0.10);" allowfullscreen loading="lazy"></iframe>
                </div>
            </div>
            <div class="details-container">
                <div class="header">
                    <h1 class="clinic-name">Skin 911 Facial and Slimming Centre</h1>
                    <div class="header-buttons">
                        @auth
                            <a href="{{ route('client.booking') }}" class="enquire-btn">Enquire</a>
                            <a href="{{ route('client.booking') }}" class="book-now-btn">Book now</a>
                        @else
                            <button class="enquire-btn" onclick="openLoginModal()">Enquire</button>
                            <button class="book-now-btn" onclick="openLoginModal()">Book now</button>
                        @endauth
                    </div>
                </div>


               <div class="row mb-3">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="city-filter">Filter by City</label>
                                    <select id="city-filter" class="form-select">
                                        <option value="">All Cities</option>
                                        @php
                                            $cities = $branches->pluck('city')->unique()->filter()->sort()->values();
                                        @endphp
                                        @foreach($cities as $city)
                                            <option value="{{ $city }}">{{ $city }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="form-group">
                                    <label for="branch_id">Branch</label>
                                    <select id="branch_id" name="branch_id" class="form-select" required>
                                        <option value="">Select Branch</option>
                                        @foreach($branches as $branch)
                                            @php if (is_array($branch)) $branch = (object) $branch; @endphp
                                            <option value="{{ $branch->id }}"
                                                    data-city="{{ $branch->city ?? '' }}"
                                                    data-address="{{ $branch->address }}"
                                                    data-hours="{{ $branch->hours ?? 'Monday - Sunday: 10:00am - 9:00pm' }}"
                                                    data-map="{{ $branch->map_src }}"
                                                    data-time_slot="{{ $branch->time_slot }}"
                                                    data-slot_capacity="{{ $branch->slot_capacity ?? 5 }}"
                                                    data-gcash-number="{{ $branch->gcash_number ?? '0917 123 4567' }}"
                                                    data-gcash-qr="{{ $branch->gcash_qr ? asset($branch->gcash_qr) : asset('img/gcash-qr.png') }}"
                                                    @if(request('branch_id') == $branch->id) selected @endif>{{ $branch->name }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('branch_id'))
                                        <div class="mt-1 text-danger"><small>{{ $errors->first('branch_id') }}</small></div>
                                    @endif
                                </div>
                            </div>
                        </div>

                <div class="sub-header">
                    <span class="rating">5.0 <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i> (196)</span>
                    <span id="branch-location-detail" class="location-detail"></span>
                </div>

                <div class="info-grid">
                    <div class="info-item">
                        <i class="fas fa-map-marker-alt icon"></i>
                        <div>
                            <span id="branch-address"></span><br>
                            <a href="#" id="get-directions" class="btn btn-primary btn-sm" style="display:none;width:100%;background:#F56289;border:none;padding:8px 16px;border-radius:8px;font-weight:600;" target="_blank">
                                <i class="fas fa-directions me-2"></i>Get Directions
                            </a>
                        </div>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-phone icon"></i>
                        <div>
                            <span><strong>Contact</strong></span><br>
                            <span id="branch-contact">Contact information coming soon</span>
                        </div>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-clock icon"></i>
                        <div id="branch-hours" class="branch-hours-grid"></div>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-credit-card icon"></i>
                        <div>
                            <span><strong>Mode of payment</strong></span><br>
                            <span>Cash, Card, E-wallet</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap');
    @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css');
 .contact-page-wrapper {
        font-family: 'Roboto', sans-serif;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 3vw 15px;
        width: 100%;
        box-sizing: border-box;
    }
    .background-container {
        background-color: #ffffff;
        padding: 3vw;
        width: 200%;
        max-width: 2200px;
        box-sizing: border-box;
        border-radius: 15px;
    }
    .contact-card {
        background-color: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        /* Remove overflow hidden so dropdown can show outside card */
        overflow: visible;
    }
    .map-container iframe { display: block; width: 100%; height: 600px; min-height: 400px; max-height: 700px; }
    .details-container { padding: 30px; }
    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }
    .clinic-name {
        font-size: clamp(1.5rem, 2.2vw, 1.8rem);
        font-weight: 700;
        color: #333;
        margin: 0;
    }
    .header-buttons { display: flex; gap: 10px; }
    .enquire-btn, .book-now-btn {
        padding: 10px 20px;
        border: none;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: background-color 0.3s ease;
        text-decoration: none;
        display: inline-block;
        text-align: center;
    }
    .enquire-btn {
        background-color: #fff;
        color: #F56289 !important;
        border: 1px solid #F56289;
    }
    .enquire-btn:hover {
        background-color: #fdeaf1;
        color: #F56289 !important;
    }
    .book-now-btn {
        background-color: #F56289;
        color: #fff !important;
    }
    .book-now-btn:hover {
        background-color: #d94e73;
        color: #fff !important;
    }

    /* Form styles for dropdowns */
    .form-group {
        margin-bottom: 1rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: #333;
        font-size: 0.95rem;
    }

    .form-select {
        width: 100%;
        padding: 0.65rem 2.5rem 0.65rem 0.75rem;
        font-size: 0.95rem;
        line-height: 1.5;
        color: #333;
        background-color: #fff;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 16px 12px;
        border: 1px solid #ccc;
        border-radius: 8px;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        appearance: none;
        cursor: pointer;
    }

    .form-select:focus {
        border-color: #F56289;
        outline: 0;
        box-shadow: 0 0 0 0.2rem rgba(245, 98, 137, 0.25);
    }

    .form-select:hover {
        border-color: #F56289;
    }

    .form-select option {
        padding: 0.5rem;
        font-size: 0.95rem;
    }

    /* Ensure text doesn't get cut off */
    select.form-select {
        min-height: 45px;
        height: auto;
        overflow: visible;
    }

    /* Responsive adjustments */
    @media (max-width: 991px) {
        .form-select {
            font-size: 0.9rem;
            padding: 0.6rem 2.25rem 0.6rem 0.7rem;
            min-height: 42px;
        }
    }

    @media (max-width: 767px) {
        .form-select {
            font-size: 0.85rem;
            padding: 0.55rem 2rem 0.55rem 0.65rem;
            background-size: 14px 10px;
            background-position: right 0.6rem center;
            min-height: 40px;
        }
        
        .form-group label {
            font-size: 0.9rem;
        }
    }

    .sub-header {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
        color: #666;
        font-size: 14px;
        margin-top: 25px;
        margin-bottom: 30px;
    }
    .rating {
        color: #333;
        font-weight: 500;
    }
    .rating .fa-star { color: #ffc107; }
    .location-detail { color: #555; }
    .info-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 25px;
        margin-bottom: 10px;
    }
    @media (min-width: 768px) {
        .info-grid {
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        }
    }
    .info-item {
        display: flex;
        align-items: flex-start;
        gap: 15px;
        font-size: 14px;
        line-height: 1.6;
    }
    .info-item .icon {
        font-size: 20px;
        color: #F56289;
        margin-top: 5px;
    }
    .branch-hours-grid {
        display: grid;
        grid-template-columns: auto 1fr;
        gap: 0 15px;
    }

    /* Hours display styling */
    .hours-display .day-group {
        margin-bottom: 8px;
        line-height: 1.4;
    }

    .hours-display .days {
        display: inline-block;
        min-width: 80px;
        color: #333;
    }

    .hours-display .hours {
        color: #666;
        font-weight: normal;
    }

    .get-directions {
        color: #F56289;
        text-decoration: none;
        font-weight: 500;
    }
    .get-directions:hover { text-decoration: underline; }

</style>


@section('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const cityFilter = document.getElementById('city-filter');
        const branchSelect = document.getElementById('branch_id');
        const mapIframe = document.getElementById('branch-map');
        const mapPlaceholder = document.getElementById('map-placeholder');
        const branchAddress = document.getElementById('branch-address');
        const branchLocationDetail = document.getElementById('branch-location-detail');
        const branchHours = document.getElementById('branch-hours');
        const branchContact = document.getElementById('branch-contact');
        const getDirectionsBtn = document.getElementById('get-directions');

        // Initialize - show placeholder
        if (mapIframe && mapPlaceholder) {
            mapIframe.style.display = 'none';
            mapPlaceholder.style.display = 'flex';
        }

        // City filter change handler
        if (cityFilter && branchSelect) {
            cityFilter.addEventListener('change', function() {
                const selectedCity = this.value;
                const branchOptions = branchSelect.querySelectorAll('option');
                
                // Show/hide branches based on city
                branchOptions.forEach(option => {
                    if (option.value === '') {
                        option.style.display = ''; // Always show "Select Branch"
                        return;
                    }
                    const branchCity = option.getAttribute('data-city') || '';
                    if (selectedCity === '' || branchCity === selectedCity) {
                        option.style.display = '';
                    } else {
                        option.style.display = 'none';
                    }
                });

                // Reset branch selection
                branchSelect.value = '';
                
                // Hide map and reset info
                if (mapIframe) {
                    mapIframe.style.display = 'none';
                    mapIframe.src = '';
                }
                if (mapPlaceholder) mapPlaceholder.style.display = 'flex';
                if (branchAddress) branchAddress.textContent = '';
                if (branchLocationDetail) branchLocationDetail.textContent = '';
                if (branchHours) branchHours.innerHTML = '';
                if (branchContact) branchContact.innerHTML = 'Contact information coming soon';
                if (getDirectionsBtn) getDirectionsBtn.style.display = 'none';
            });
        }

        // Branch selection change handler
        if (branchSelect) {
            branchSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                
                if (!selectedOption || selectedOption.value === '') {
                    // No branch selected - show placeholder
                    if (mapIframe) {
                        mapIframe.style.display = 'none';
                        mapIframe.src = '';
                    }
                    if (mapPlaceholder) mapPlaceholder.style.display = 'flex';
                    if (branchAddress) branchAddress.textContent = '';
                    if (branchLocationDetail) branchLocationDetail.textContent = '';
                    if (branchHours) branchHours.innerHTML = '';
                    if (branchContact) branchContact.innerHTML = 'Contact information coming soon';
                    if (getDirectionsBtn) getDirectionsBtn.style.display = 'none';
                    return;
                }

                // Get branch data from data attributes
                const mapSrc = selectedOption.getAttribute('data-map') || '';
                const address = selectedOption.getAttribute('data-address') || '';
                const hours = selectedOption.getAttribute('data-hours') || '';
                const city = selectedOption.getAttribute('data-city') || '';
                
                console.log('Selected branch:', selectedOption.text);
                console.log('Map src:', mapSrc);
                console.log('Address:', address);

                // Update map
                if (mapIframe && mapPlaceholder) {
                    if (mapSrc && mapSrc.trim() !== '') {
                        mapIframe.src = mapSrc;
                        mapIframe.style.display = 'block';
                        mapPlaceholder.style.display = 'none';
                        console.log('Map loaded successfully');
                    } else {
                        mapIframe.style.display = 'none';
                        mapPlaceholder.style.display = 'flex';
                        console.log('No map source available');
                    }
                }

                // Update address
                if (branchAddress) {
                    branchAddress.textContent = address || 'Address not available';
                }

                // Update location detail (city)
                if (branchLocationDetail) {
                    branchLocationDetail.textContent = city || '';
                }

                // Update hours
                if (branchHours) {
                    if (hours && hours.trim() !== '') {
                        branchHours.innerHTML = hours;
                    } else {
                        branchHours.innerHTML = '<div style="color: #888; font-style: italic;">Coming soon</div>';
                    }
                }

                // Update contact info (you can enhance this with actual contact data)
                if (branchContact) {
                    branchContact.innerHTML = 'Contact information coming soon';
                }

                // Update directions button
                if (getDirectionsBtn && address) {
                    const directionsUrl = 'https://www.google.com/maps/dir/?api=1&destination=' + encodeURIComponent(address);
                    getDirectionsBtn.href = directionsUrl;
                    getDirectionsBtn.style.display = mapSrc && mapSrc.trim() !== '' ? 'block' : 'none';
                }
            });
        }
    });
    </script>
@endsection
