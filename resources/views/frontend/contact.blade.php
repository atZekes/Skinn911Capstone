@extends('layouts.app')
@section('content')
@section('hide_layout_banner')@endsection
    <div class="responsive-banner-bg"></div>

    <!-- per-view contact styles -->
    <link rel="stylesheet" href="{{ asset('css/frontend/contact.css') }}">

<div class="contact-page-wrapper">
    <div class="background-container">
        <div class="contact-card">
            <div class="map-container">
                <!-- Set working default map to Cebu City -->
                                    <iframe
                        id="map"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3925.263004968588!2d123.9016596739544!3d10.320824489801565!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33a9990509381945%3A0x73e7592e1d0f982f!2sSkin911%20Medical!5e0!3m2!1sen!2sph!4v1755606033060!5m2!1sen!2sph"
                        width="100%"
                        height="300"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
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


                <div class="branch-selector">
                    <label>Choose a branch:</label>

                    <!-- DEBUG: Show branch count -->
                    <script>console.log('Branches from server:', {{ $branches->count() }});</script>

                    @if($branches->count() > 0)
                        <!-- Hidden select that holds the value for our script -->
                        <select id="branch-select" name="branches" style="display: none;">
                            @foreach($branches as $branch)
                                <option value="{{ $branch->id }}"
                                        data-map-src="{{ $branch->map_src ?? '' }}"
                                        data-address="{{ $branch->address ?? '' }}"
                                        data-location-detail="{{ $branch->location_detail ?? '' }}"
                                        data-hours="{{ $branch->hours ?? '' }}"
                                        data-contact-number="{{ $branch->contact_number ?? '' }}"
                                        data-telephone-number="{{ $branch->telephone_number ?? '' }}"
                                        data-operating-days="{{ $branch->operating_days ?? '' }}">
                                    {{ $branch->name }}
                                </option>
                                <!-- DEBUG: Log each branch -->
                                <script>console.log('Branch: {{ $branch->name }}', 'Map: {{ $branch->map_src ?? "EMPTY" }}');</script>
                            @endforeach
                        </select>                        <!-- Custom styled dropdown that users see -->
                        <div class="custom-select-wrapper">
                            <div class="custom-select-trigger">
                                <span>{{ $branches->first()->name }}</span>
                                <i class="fas fa-chevron-down arrow"></i>
                            </div>
                            <div class="custom-options">
                                @foreach($branches as $branch)
                                    <div class="custom-option"
                                         data-value="{{ $branch->id }}"
                                         data-map-src="{{ $branch->map_src ?? '' }}"
                                         data-address="{{ $branch->address ?? '' }}"
                                         data-location-detail="{{ $branch->location_detail ?? '' }}"
                                         data-hours="{{ $branch->hours ?? '' }}"
                                         data-contact-number="{{ $branch->contact_number ?? '' }}"
                                         data-telephone-number="{{ $branch->telephone_number ?? '' }}"
                                         data-operating-days="{{ $branch->operating_days ?? '' }}">
                                        {{ $branch->name }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <!-- Show message when no branches are available -->
                        <div class="no-branches-message">
                            <p style="color: #666; font-style: italic;">No branches are currently available. Please check back later.</p>
                        </div>
                    @endif
                            <!-- To add more, just copy a line above -->
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
                            <a href="#" id="get-directions" class="get-directions">Get directions</a>
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

    .branch-selector { margin-top: 25px; }
    .branch-selector label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: #333;
    }

    /* --- Custom Dropdown Styles --- */
    .custom-select-wrapper {
        position: relative;
        cursor: pointer;
        /* Add high z-index to wrapper */
        z-index: 1000;
    }
    .custom-select-trigger {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 16px;
        background-color: #fff;
    }
    .custom-select-trigger .arrow {
        transition: transform 0.3s ease;
    }
    .custom-select-wrapper.open .arrow {
        transform: rotate(180deg);
    }
    .custom-options {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background-color: #fff;
        border: 1px solid #ccc;
        border-top: none;
        border-radius: 0 0 8px 8px;
        /* Increase z-index so dropdown appears above everything */
        z-index: 1001;
        /* Add shadow to make dropdown more visible */
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);

        /* THIS IS THE KEY FOR SCROLLING */
        max-height: 200px; /* Set a max height */
        overflow-y: auto;   /* Add a scrollbar if content exceeds max height */
    }
    .custom-select-wrapper.open .custom-options {
        display: block;
    }
    .custom-option {
        padding: 12px;
        transition: background-color 0.2s ease;
    }
    .custom-option:hover {
        background-color: #fdeaf1;
    }
    /* --- End Custom Dropdown Styles --- */

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
    <script src="{{ asset('js/frontend/contact.js') }}"></script>
@endsection
