@extends('layouts.app')
@section('content')
@section('hide_layout_banner')@endsection
    <div class="responsive-banner-bg"></div>
    <!-- page-specific CSS (per-view folder) -->
    <link rel="stylesheet" href="{{ asset('css/frontend/services.css') }}">


<!-- services_area_start -->
<div class="services_area padding_top">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="text-center section_title mb-100">
                    <span>Skin911 Services</span>
                    <h3>Professional Beauty & Wellness Solutions</h3>
                </div>
            </div>
        </div>

        @if(isset($services) && $services->count() > 0)
        <!-- Category Filter Buttons -->
        <div class="mb-5 row">
            <div class="col-xl-12">
                <div class="text-center category_filter">
                    <button class="filter_btn active" data-category="all">All Services</button>
                    @php
                        $categories = $services->pluck('category')->unique()->filter();
                    @endphp
                    @foreach($categories as $category)
                        <button class="filter_btn" data-category="{{ strtolower(str_replace(' ', '-', $category)) }}">{{ $category }}</button>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Services by Category -->
        <div id="services-container">
            @foreach($categories as $category)
                @php
                    $catSlug = strtolower(str_replace(' ', '-', $category));
                    $catLabel = $category;
                    $filteredServices = $services
                        ->where('category', $category)
                        ->whereNotNull('treatment_details')
                        ->whereNotNull('image')
                        ->unique('name');
                @endphp

                <div class="category-section" id="{{ $catSlug }}-section">
                    <div class="category-header">
                        <h3>{{ $catLabel }}</h3>
                        <p>Browse our {{ strtolower($catLabel) }} treatments</p>
                    </div>
                    <div class="services-carousel">
                        <div class="carousel-container">
                            @foreach($filteredServices as $service)
                                @php
                                    $serviceSlug = strtolower(str_replace(' ', '-', $service->name));

                                    // Map service names to ACTUAL existing image files (no spaces in URLs)
                                    $imageMap = [
                                        // Facial Services
                                        'hydrafacial' => 'HydraFacial.jpg',
                                        'diamond-peel' => 'Diamond peel.jpg',
                                        'acne-laser-+-acne-facial' => 'Acne laser + Acne Facial.jpg',
                                        'acne-treatment' => 'Acne Treatment.jpg',
                                        'skin-rejuvenation-laser-+-facial' => 'Skin Rejuvenation Laser + Facial.jpg',
                                        'wart-removal-(face-and-neck)' => 'Wart removal (face and neck).jpg',

                                        // Immuno Boosters
                                        'immuno-gold-+-vitamin-c-treatment' => 'Immuno Gold + Vitamin C Treatment.jpg',
                                        'cinderella-drip-treatment' => 'Cinderella Drip Treatment.jpg',
                                        'cindella-drip-treatment' => 'Cinderella Drip Treatment.jpg',
                                        'luminous-white-drip-treatment' => 'Luminous White Drip Treatment.jpg',
                                        'elea-white-treatment' => 'Elea White Treatment.jpg',
                                        'collagen-injection' => 'Collagen Injection.jpg',
                                        'placenta-injection' => 'Placenta Injection.jpg',

                                        // Permanent Hair Removal & Body
                                        'underarm-whitening' => 'Underarm whitening.jpg',
                                        'underarms' => 'Underarm whitening.jpg',
                                        'underarms-3-sessions' => 'Underarm whitening.jpg',

                                        // Slimming Services
                                        'radio-frequency-rf' => 'Radio frequency RF.jpg',
                                        'rf' => 'Radio frequency RF.jpg',
                                        'lipo-cavitation' => 'Lipo-cavitation.jpg',
                                        'lipo-cavitation-+-rf' => 'Lipo Cavitation + RF.jpg',
                                        'trio-slim' => 'TRIO slim.jpg',
                                        'diode-lipo-laser' => 'Diode Lipo Laser.jpg',
                                        'hifu' => 'HIFU.jpg',
                                        'hifu-ultralift' => 'HIFU Ultralift.jpg',
                                    ];

                                    // Get correct image or fallback to database image
                                    $correctImage = isset($imageMap[$serviceSlug])
                                        ? '/img/services/' . $imageMap[$serviceSlug]
                                        : $service->image;
                                @endphp
                                <div class="service-card" data-service="{{ $serviceSlug }}">
                                    <div class="service-image"
                                         style="background-image:url('{{ asset($correctImage) }}');background-size:cover;background-position:center;">
                                    </div>
                                    <div class="service-info">
                                        <h4>{{ $service->name }}</h4>
                                        @if($service->price)
                                            <p class="price">₱{{ number_format($service->price, 2) }}</p>
                                        @endif
                                        @if($service->sessions)
                                            <p class="sessions">{{ $service->sessions }}</p>
                                        @endif
                                        <button class="expand-btn">Learn More</button>
                                    </div>
                                    <div class="service-details">
                                        <h5>Treatment Details</h5>
                                        <p>{{ $service->treatment_details ?? 'No details available.' }}</p>
                                        @if($service->benefits)
                                            <ul>
                                                @foreach(explode(',', $service->benefits) as $benefit)
                                                    <li>{{ trim($benefit) }}</li>
                                                @endforeach
                                            </ul>
                                        @endif
                                        <div class="booking-actions">
                                            <a href="#" class="book-now-btn" data-service-id="{{ $service->id }}">Book Now</a>
                                            <a href="#" class="consultation-btn back-btn">Back</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button class="carousel-nav prev" data-category="{{ $catSlug }}">‹</button>
                        <button class="carousel-nav next" data-category="{{ $catSlug }}">›</button>
                    </div>
                </div>
            @endforeach
        </div>
        @else
        <div class="row">
            <div class="col-xl-12">
                <div class="text-center no-services-message">
                    <h3>Coming Soon</h3>
                    <p>We're working on bringing you amazing services. Please check back later.</p>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
<!-- services_area_end -->

<!-- page-specific styles moved to public/css/services.css -->

<!-- forQuery_start -->
<div class="forQuery">
    <div class="container">
        <div class="row">
            <div class="col-xl-10 offset-xl-1 col-md-12">
                <div class="Query_border">
                    <div class="row align-items-center justify-content-center">
                        <div class="col-xl-6 col-md-6">
                            <div class="Query_text">
                                <p>Ready to Book Your Service?</p>
                            </div>
                        </div>
                        <div class="col-xl-6 col-md-6">
                            <div class="phone_num">
                                <a href="{{route('contact')}}" class="mobile_no">Contact us</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- forQuery_end-->

@endsection

@section('scripts')
    <!-- expose auth state for services.js -->
    <script>window.isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};</script>
    <script src="{{ asset('js/frontend/services.js') }}"></script>
@endsection
