@extends('layouts.app')
@section('content')
@section('hide_layout_banner')@endsection
    <!-- Responsive Banner -->

    <!-- per-view index styles -->
    <link rel="stylesheet" href="{{ asset('css/frontend/index.css') }}">

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

        @if(isset($claimedPromo))
        <!-- Promo Claim Banner -->
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; border: none; border-radius: 12px;">
            <div class="d-flex align-items-center">
                <i class="fas fa-gift me-3" style="font-size: 1.5rem;"></i>
                <div>
                    <strong>🎉 Promo Claimed!</strong>
                    <p class="mb-0 mt-1">You're claiming: <strong>{{ $claimedPromo->title }}</strong> ({{ $claimedPromo->discount }}% OFF)</p>
                    <small>Use code: <strong>{{ $claimedPromo->code }}</strong> when booking</small>
                </div>
            </div>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
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
                        ->whereNotNull('image')
                        ->unique('name');
                @endphp

                <div class="category-section" id="{{ $catSlug }}-section">
                    <div class="category-header">
                        <h3>{{ $catLabel }}</h3>
                        <p>Browse our {{ strtolower($catLabel) }} treatments</p>
                    </div>
                    <div class="services-carousel">
                        <div class="carousel-container owl-carousel owl-theme">
                            @foreach($filteredServices as $service)
                                @php
                                    $serviceSlug = strtolower(str_replace(' ', '-', $service->name));

                                    // Get image from database
                                    $correctImage = $service->image;
                                @endphp
                                <div class="service-card" data-service="{{ $serviceSlug }}" style="width:320px;min-width:320px;max-width:320px;border-radius:16px;position:relative;">
                                    <div class="service-image"
                                         style="border-radius:16px 16px 0 0;overflow:hidden;width:100%;height:180px;background-image:url('{{ asset($correctImage) }}');background-size:cover;background-position:center;">
                                    </div>
                                    <div class="p-3 service-info" style="border-radius:0 0 16px 16px;">
                                        <h4 class="mb-1" style="color:#F56289;font-size:1.1rem;font-weight:600;">{{ $service->name }}</h4>
                                        @if($service->price)
                                            <p class="mb-1 price" style="font-size:1rem;color:#222;"><strong>₱{{ number_format($service->price, 2) }}</strong></p>
                                        @endif
                                        @if($service->sessions)
                                            <p class="mb-1 sessions" style="font-size:0.95rem;color:#888;">{{ $service->sessions }}</p>
                                        @endif
                                        <button class="mt-2 expand-btn btn btn-outline-pink btn-sm w-100" style="border-radius:6px;">Learn More</button>
                                    </div>
                                    <div class="p-3 service-details" style="display:none;border-radius:0 0 16px 16px;background:#fff;box-shadow:0 2px 12px rgba(245,98,137,0.08);position:absolute;top:0;left:0;width:100%;height:100%;z-index:2;">
                                        <h5 class="mb-2">Treatment Details</h5>
                                        <p style="font-size:0.95rem;line-height:1.4;word-break:break-word;margin-bottom:0.5rem;">{{ $service->treatment_details ?? 'No details available.' }}</p>
                                        @if($service->benefits)
                                            <ul>
                                                @foreach(explode(',', $service->benefits) as $benefit)
                                                    <li>{{ trim($benefit) }}</li>
                                                @endforeach
                                            </ul>
                                        @endif
                                        <div class="gap-2 mt-3 booking-actions d-flex justify-content-center">
                                            <a href="#" class="book-now-btn btn btn-pink btn-sm" data-service-id="{{ $service->id }}">Book Now</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
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
