@extends('layouts.app')
@section('content')
@section('hide_layout_banner')@endsection
    <!-- Responsive Banner -->

    <!-- per-view index styles -->
    <link rel="stylesheet" href="{{ asset('css/frontend/index.css') }}">

    @if(request('showLogin'))
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof openLoginModalBtn !== 'undefined') {
                openLoginModalBtn.click();
            } else if (document.getElementById('openLoginModalBtn')) {
                document.getElementById('openLoginModalBtn').click();
            }
        });
        </script>
    @endif
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
        <div class="slider_area">
    <!-- about_area_start -->
    <div class="about_area">
        <div class="container">
            <div class="row">
                <div class="col-xl-5 col-lg-5">
                    <div class="about_info">
                        <div class="section_title mb-20px">
                            <span>About Us</span>
                            <h3> A prominent facial and slimming center in the heart of the city </h3>
                        </div>
                        <p> The company's mission is to provide quality beauty and skincare services at affordable prices, making skincare accessible beyond just the affluent.
                            This approach has been a key factor in their steady growth and customer loyalty.
                            Skin911's core principles are quality products and services, affordable prices, and professional and ethical staff.</p>
                        <a href="{{route ('aboutus') }}" class="line-button">Learn More</a>
                    </div>
                </div>
                <div class="col-xl-7 col-lg-7">
                    <div class="about_thumb d-flex">
                        <div class="img_1">
                            <img src="{{ asset('img/skin1.jpg') }}" alt="">
                        </div>
                        <div class="img_2">
                            <img src="{{ asset('img/skin2.jpg') }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- about_area_end -->

    <!-- offers_area_start -->
    <div class="offers_area">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="text-center section_title mb-100">
                        <span>Exclusive Offers</span>
                        <h3>Special Promotions</h3>
                    </div>
                </div>
            </div>
            @if($promos && $promos->count() > 0)
                @if($promos->count() >= 3)
                <!-- Promo Carousel for 3+ promos -->
                <div class="promo-carousel-container">
                    <div class="promo-carousel owl-carousel owl-theme">
                        @foreach($promos as $promo)
                        <div class="promo-slide">
                            <div class="single_offers">
                                <div class="about_thumb">
                                    @if($promo->image)
                                        <img src="{{ asset($promo->image) }}" alt="{{ $promo->title }}" style="width:100%; height:200px; object-fit:cover;">
                                    @else
                                        <img src="{{ asset('img/skin3.jpg') }}" alt="{{ $promo->title }}" style="width:100%; height:200px; object-fit:cover;">
                                    @endif
                                </div>
                                <h3>{{ $promo->title }}</h3>
                                @if($promo->description)
                                    <p class="mb-2">{{ Str::limit($promo->description, 100) }}</p>
                                @endif
                                <div class="promo-code mb-2">
                                    <strong>Use Code: <span style="color:#e75480;">{{ $promo->code }}</span></strong>
                                </div>
                                <div class="discount-badge mb-3">
                                    <span class="badge" style="background:#e75480; color:white; font-size:1.1rem; padding:8px 16px;">{{ $promo->discount }}% OFF</span>
                                </div>
                                <div class="services-list mb-3">
                                    <strong>Included Services:</strong>
                                    <ul class="mt-2">
                                        @if($promo->services && $promo->services->count() > 0)
                                            @foreach($promo->services->take(3) as $service)
                                                <li>{{ $service->name }}</li>
                                            @endforeach
                                            @if($promo->services->count() > 3)
                                                <li class="more-services-toggle" data-promo-id="{{ $promo->id }}">
                                                    <a href="#" onclick="togglePromoServices({{ $promo->id }}); return false;" style="color:#e75480; text-decoration:underline;">
                                                        <em>and {{ $promo->services->count() - 3 }} more...</em>
                                                    </a>
                                                </li>
                                                <div class="additional-services" id="additional-services-{{ $promo->id }}" style="display: none;">
                                                    @foreach($promo->services->skip(3) as $service)
                                                        <li>{{ $service->name }}</li>
                                                    @endforeach
                                                    <li class="show-less-toggle" data-promo-id="{{ $promo->id }}" style="margin-top: 8px;">
                                                        <a href="#" onclick="togglePromoServices({{ $promo->id }}); return false;" style="color:#e75480; text-decoration:underline; font-weight: 500;">
                                                            <em>Show less...</em>
                                                        </a>
                                                    </li>
                                                </div>
                                            @endif
                                        @elseif($promo->category)
                                            <li>All {{ strtolower($promo->category) }} services</li>
                                        @else
                                            <li>All services</li>
                                        @endif
                                    </ul>
                                </div>
                                <div class="branch-info mb-3">
                                    <strong>Available at:</strong>
                                    @if($promo->branch)
                                        <span class="badge" style="background:#28a745; color:white;">{{ $promo->branch->name }}</span>
                                    @else
                                        <span class="badge" style="background:#17a2b8; color:white;">All Branches</span>
                                    @endif
                                </div>
                                @if($promo->expiration_message)
                                    <div class="expiration-message mb-3" style="background:#fff3cd;color:#856404;padding:8px 12px;border-radius:6px;font-size:0.9rem;font-weight:600;text-align:center;">
                                        {{ $promo->expiration_message }}
                                    </div>
                                @endif
                                <div class="offer-buttons d-flex gap-2 justify-content-center mt-3">
                                    <a href="{{ route('services') }}" class="btn btn-outline-pink btn-sm">View Services</a>
                                    @if($promo->is_available && (!auth()->check() || $promo->canUserClaim(auth()->id())))
                                        <a href="#" onclick="handleClaimPromo('{{ $promo->code }}', '{{ $promo->id }}'); return false;" class="btn btn-pink btn-sm">Claim Now!</a>
                                    @else
                                        <button class="btn btn-secondary btn-sm" disabled>
                                            @if(!$promo->is_available)
                                                Unavailable
                                            @elseif(auth()->check() && !$promo->canUserClaim(auth()->id()))
                                                Already Claimed
                                            @else
                                                Login Required
                                            @endif
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @else
                <!-- Static Grid for 1-2 promos -->
                <div class="row">
                    @foreach($promos as $promo)
                    <div class="col-xl-{{ $promos->count() == 1 ? '12' : '6' }} col-md-{{ $promos->count() == 1 ? '12' : '6' }} mb-4">
                        <div class="single_offers">
                            <div class="about_thumb">
                                @if($promo->image)
                                    <img src="{{ asset($promo->image) }}" alt="{{ $promo->title }}" style="width:100%; height:200px; object-fit:cover;">
                                @else
                                    <img src="{{ asset('img/skin3.jpg') }}" alt="{{ $promo->title }}" style="width:100%; height:200px; object-fit:cover;">
                                @endif
                            </div>
                            <h3>{{ $promo->title }}</h3>
                            @if($promo->description)
                                <p class="mb-2">{{ Str::limit($promo->description, 100) }}</p>
                            @endif
                            <div class="promo-code mb-2">
                                <strong>Use Code: <span style="color:#e75480;">{{ $promo->code }}</span></strong>
                            </div>
                            <div class="discount-badge mb-3">
                                <span class="badge" style="background:#e75480; color:white; font-size:1.1rem; padding:8px 16px;">{{ $promo->discount }}% OFF</span>
                            </div>
                            <div class="services-list mb-3">
                                <strong>Included Services:</strong>
                                <ul class="mt-2">
                                    @if($promo->services && $promo->services->count() > 0)
                                        @foreach($promo->services->take(3) as $service)
                                            <li>{{ $service->name }}</li>
                                        @endforeach
                                        @if($promo->services->count() > 3)
                                            <li class="more-services-toggle" data-promo-id="{{ $promo->id }}">
                                                <a href="#" onclick="togglePromoServices({{ $promo->id }}); return false;" style="color:#e75480; text-decoration:underline;">
                                                    <em>and {{ $promo->services->count() - 3 }} more...</em>
                                                </a>
                                            </li>
                                            <div class="additional-services" id="additional-services-{{ $promo->id }}" style="display: none;">
                                                @foreach($promo->services->skip(3) as $service)
                                                    <li>{{ $service->name }}</li>
                                                @endforeach
                                                <li class="show-less-toggle" data-promo-id="{{ $promo->id }}" style="margin-top: 8px;">
                                                    <a href="#" onclick="togglePromoServices({{ $promo->id }}); return false;" style="color:#e75480; text-decoration:underline; font-weight: 500;">
                                                        <em>Show less...</em>
                                                    </a>
                                                </li>
                                            </div>
                                        @endif
                                    @elseif($promo->category)
                                        <li>All {{ strtolower($promo->category) }} services</li>
                                    @else
                                        <li>All services</li>
                                    @endif
                                </ul>
                            </div>
                            <div class="branch-info mb-3">
                                <strong>Available at:</strong>
                                @if($promo->branch)
                                    <span class="badge" style="background:#28a745; color:white;">{{ $promo->branch->name }}</span>
                                @else
                                    <span class="badge" style="background:#17a2b8; color:white;">All Branches</span>
                                @endif
                            </div>
                            @if($promo->expiration_message)
                                <div class="expiration-message mb-3" style="background:#fff3cd;color:#856404;padding:8px 12px;border-radius:6px;font-size:0.9rem;font-weight:600;text-align:center;">
                                    {{ $promo->expiration_message }}
                                </div>
                            @endif
                            <div class="offer-buttons d-flex gap-2 justify-content-center mt-3">
                                <a href="{{ route('services') }}" class="btn btn-outline-pink btn-sm">View Services</a>
                                @if($promo->is_available && (!auth()->check() || $promo->canUserClaim(auth()->id())))
                                    <a href="#" onclick="handleClaimPromo('{{ $promo->code }}', '{{ $promo->id }}'); return false;" class="btn btn-pink btn-sm">Claim Now!</a>
                                @else
                                    <button class="btn btn-secondary btn-sm" disabled>
                                        @if(!$promo->is_available)
                                            Unavailable
                                        @elseif(auth()->check() && !$promo->canUserClaim(auth()->id()))
                                            Already Claimed
                                        @else
                                            Login Required
                                        @endif
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
            @else
            <!-- Fallback to static offers when no promos are available -->
            <div class="row">
                <div class="col-xl-4 col-md-4">
                    <div class="single_offers">
                        <div class="about_thumb">
                            <img src="{{ asset('img/skin3.jpg') }}" alt="">
                        </div>
                        <h3>Up to 35% savings on Facial <br>
                            </h3>
                        <ul>
                            <li>Warts removal</li>
                            <li>Hydrafacial</li>
                            <li>Microneedling</li>
                        </ul>
                        <div class="offer-buttons d-flex gap-2 justify-content-center mt-3">
                            <a href="{{ route('services') }}" class="btn btn-outline-pink btn-sm">View Services</a>
                            <a href="#" onclick="document.getElementById('openLoginModalBtn').click(); return false;" class="btn btn-pink btn-sm">Claim Now!</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-4">
                    <div class="single_offers">
                        <div class="about_thumb">
                            <img src="{{ asset('img/skin4.jpg') }}" alt="">
                        </div>
                        <h3>Up to 35% savings on Whitening and Rejuvenation <br>
                            </h3>
                        <ul>
                            <li>Underarm whitening</li>
                            <li>Pigmentation Whitening</li>
                            <li>Skin Rejuvenation</li>
                        </ul>
                        <div class="offer-buttons d-flex gap-2 justify-content-center mt-3">
                            <a href="{{ route('services') }}" class="btn btn-outline-pink btn-sm">Learn More</a>
                            <a href="#" onclick="document.getElementById('openLoginModalBtn').click(); return false;" class="btn btn-pink btn-sm">Book Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-4">
                    <div class="single_offers">
                        <div class="about_thumb">
                            <img src="{{ asset('img/skin5.jpg') }}" alt="">
                        </div>
                        <h3>Up to 35% savings on Slimming<br>
                            </h3>
                        <ul>
                            <li>Redio Frequency</li>
                            <li>Lipo-Cavitation</li>
                            <li>Trio Slim</li>
                        </ul>
                        <div class="offer-buttons d-flex gap-2 justify-content-center mt-3">
                            <a href="{{ route('services') }}" class="btn btn-outline-pink btn-sm">Learn More</a>
                            <a href="#" onclick="document.getElementById('openLoginModalBtn').click(); return false;" class="btn btn-pink btn-sm">Book Now</a>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <div class="offers_area">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="text-center section_title mb-100">

                        <h3>Our Services</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-4 col-md-4">
                    <div class="single_offers">
                        <div class="about_thumb">
                            <img src="{{ asset('img/skin3.jpg') }}" alt="">
                        </div>
                        <h3> Facial Services <br>
                            </h3>
                        <ul>
                            <li>Warts removal</li>
                            <li>Hydrafacial</li>
                            <li>Microneedling</li>
                        </ul>
                        <div class="offer-buttons d-flex gap-2 justify-content-center mt-3">
                            <a href="{{ route('services') }}" class="btn btn-outline-pink btn-sm">Learn More</a>
                            <a href="#" onclick="document.getElementById('openLoginModalBtn').click(); return false;" class="btn btn-pink btn-sm">Book Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-4">
                    <div class="single_offers">
                        <div class="about_thumb">
                            <img src="{{ asset('img/skin4.jpg') }}" alt="">
                        </div>
                        <h3>Immuno Boosters <br>
                            </h3>
                        <ul>
                            <li>Cindella Drip</li>
                            <li>Collagen injection</li>
                            <li>Elea White Dripe</li>
                        </ul>
                        <div class="offer-buttons d-flex gap-2 justify-content-center mt-3">
                            <a href="{{ route('services') }}" class="btn btn-outline-pink btn-sm">Learn More</a>
                            <a href="#" onclick="document.getElementById('openLoginModalBtn').click(); return false;" class="btn btn-pink btn-sm">Book Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-4">
                    <div class="single_offers">
                        <div class="about_thumb">
                            <img src="{{ asset('img/skin5.jpg') }}" alt="">
                        </div>
                        <h3>Slimming Services<br>
                            </h3>
                        <ul>
                            <li>Lipo-Cavitation</li>
                            <li>Radio Frequency</li>
                            <li>Trio Slim</li>
                        </ul>
                        <div class="offer-buttons d-flex gap-2 justify-content-center mt-3">
                            <a href="{{ route('services') }}" class="btn btn-outline-pink btn-sm">Learn More</a>
                            <a href="#" onclick="document.getElementById('openLoginModalBtn').click(); return false;" class="btn btn-pink btn-sm">Book Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>






    <!-- offers_area_end -->

    <!-- video_area_start -->
    <div class="video_area overlay" style="padding: 0px 0;">
        <div class="text-center video_area_inner">

            <video
            id="scroll-play-video"
            muted
            loop
            playsinline
            preload="metadata"
            poster="{{ asset('img/skin2.jpg') }}"
            style="width:100%;height:100vh;object-fit:cover;object-position:center top;display:block">

            <source src="{{ asset('videos/skin911 AD.mp4') }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        </div>
    </div>
    <!-- video_area_end -->

    <!-- about_area_start -->
    <div class="about_area">
        <div class="container">
            <div class="row">
                <div class="col-xl-7 col-lg-7">
                    <div class="about_thumb2 d-flex">
                        <div class="img_1">
                            <img src="{{ asset('img/about/skin6.jpg') }}" alt="">
                        </div>
                        <div class="img_2">
                            <img src="{{ asset('img/about/skin7.jpg') }}" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-xl-5 col-lg-5">
                    <div class="about_info">
                        <div class="section_title mb-20px">
                            <span>Services</span>
                            <h3>We Provide Advanced and Rejuvenating Skincare</h3>
                        </div>
                        <p>We are committed to delivering exceptional and effective beauty treatments. Our team of skilled professionals utilizes advanced techniques and quality products to address your unique skincare needs.
                            From revitalizing facials to innovative slimming solutions, we are dedicated to helping you achieve your desired results.
                            Experience our wide range of services, all designed to be both high-quality and affordable, ensuring everyone can enjoy the confidence that comes with beautiful, healthy skin.</p>
                        <a href="{{route('aboutus') }}" class="line-button">Learn More</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- about_area_end -->

    <!-- features_room_startt -->
    <div class="features_room">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="text-center section_title mb-100">
                        <span>Featured Services</span>
                        <h3>Choose a Better Service</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="rooms_here">
            <div class="single_rooms">
                <a href="{{ route('services') }}" class="room_thumb_link">
                    <div class="room_thumb">
                        <img src="{{ asset('img/services/3.png') }}" alt="">
                        <div class="room_heading">
                            <div class="room_heading_inner">
                                <span>2,999.00 PHP for 8 Sessions</span>
                                <h3>Radio Frequency</h3>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="single_rooms">
                <a href="{{ route('services') }}" class="room_thumb_link">
                    <div class="room_thumb">
                        <img src="{{ asset('img/services/4.png') }}" alt="">
                        <div class="room_heading">
                            <div class="room_heading_inner">
                                <span>1,499.00 PHP for 3+1 sessions</span>
                                <h3>Complete facial treatment</h3>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="single_rooms">
                <a href="{{ route('services') }}" class="room_thumb_link">
                    <div class="room_thumb">
                        <img src="{{ asset('img/services/8.png') }}" alt="">
                        <div class="room_heading">
                            <div class="room_heading_inner">
                                <span>4,999.00 PHP for 10 Sessions</span>
                                <h3>Immuno Gold</h3>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="single_rooms">
                <a href="{{ route('services') }}" class="room_thumb_link">
                    <div class="room_thumb">
                        <img src="{{ asset('img/services/9.png') }}" alt="">
                        <div class="room_heading">
                            <div class="room_heading_inner">
                                <span>7,499.00 PHP for 5 sessions</span>
                                <h3>Celestial White Drip</h3>
                            </div>
                        </div>
                    </div>
                </a>
        </div>
    </div>
    <!-- features_room_end -->

    <!-- forQuery_start -->
    <div class="forQuery">
        <div class="container">
            <div class="row">
                <div class="col-xl-10 offset-xl-1 col-md-12">
                    <div class="Query_border">
                        <div class="row align-items-center justify-content-center">
                            <div class="col-xl-6 col-md-6">
                                <div class="Query_text">
                                    <p>For Reservation?</p>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6">
                                <div class="phone_num">
                                    <a href="{{ route('contact') }}" class="mobile_no">Contact us</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- forQuery_end-->

    <!-- instragram_area_start -->
    <div class="instragram_area">
        <div class="single_instagram">
            <img src="{{ asset('img/instragram/1.png') }}" alt="">
            <div class="ovrelay">
                <a href="https://www.instagram.com/skin911/?hl=en">
                    <i class="fa fa-instagram"></i>
                </a>
            </div>
        </div>
        <div class="single_instagram">
            <img src="{{ asset('img/instragram/2.png') }}" alt="">
            <div class="ovrelay">
                <a href="https://www.instagram.com/skin911/?hl=en">
                    <i class="fa fa-instagram"></i>
                </a>
            </div>
        </div>
        <div class="single_instagram">
            <img src="{{ asset('img/instragram/3.png') }}" alt="">
            <div class="ovrelay">
                <a href="https://www.instagram.com/skin911/?hl=en">
                    <i class="fa fa-instagram"></i>
                </a>
            </div>
        </div>
        <div class="single_instagram">
            <img src="{{ asset('img/instragram/4.png') }}" alt="">
            <div class="ovrelay">
                <a href="https://www.instagram.com/skin911/?hl=en">
                    <i class="fa fa-instagram"></i>
                </a>
            </div>
        </div>
        <div class="single_instagram">
            <img src="{{ asset('img/instragram/5.png') }}" alt="">
            <div class="ovrelay">
                <a href="https://www.instagram.com/skin911/?hl=en">
                    <i class="fa fa-instagram"></i>
                </a>
            </div>
        </div>
    </div>
    <!-- instragram_area_end -->

    <!-- per-view index JS moved to scripts section -->


@endsection

@section('scripts')
<!-- pageshow reload handled in per-view index.js -->
<script src="{{ asset('js/frontend/index.js') }}"></script>

<!-- Promo Carousel Initialization -->
<script>
$(document).ready(function(){
    // Initialize promo carousel if it exists (3+ promos)
    if ($('.promo-carousel').length > 0) {
        // Count total promo slides
        var totalSlides = $('.promo-carousel .promo-slide').length;

        $('.promo-carousel').owlCarousel({
            loop: false, // Disable infinite loop - stop at end of promos
            margin: 20,
            nav: totalSlides > 3, // Only show nav if more than 3 promos
            dots: totalSlides > 3, // Only show dots if more than 3 promos
            autoplay: totalSlides > 3, // Only autoplay if more than 3 promos
            autoplayTimeout: 5000,
            autoplayHoverPause: true,
            smartSpeed: 800,
            mouseDrag: totalSlides > 3, // Only enable drag if more than 3 promos
            touchDrag: totalSlides > 3, // Only enable touch drag if more than 3 promos
            responsive: {
                0: {
                    items: 1,
                    margin: 10,
                    loop: false, // No infinite loop on mobile
                    mouseDrag: totalSlides > 1, // Enable drag on mobile if more than 1 promo
                    touchDrag: totalSlides > 1
                },
                768: {
                    items: 2,
                    margin: 15,
                    loop: false, // No infinite loop on tablet
                    mouseDrag: totalSlides > 2, // Enable drag on tablet if more than 2 promos
                    touchDrag: totalSlides > 2
                },
                992: {
                    items: 3,
                    margin: 20,
                    loop: false, // No infinite loop on desktop
                    mouseDrag: totalSlides > 3, // Enable drag on desktop if more than 3 promos
                    touchDrag: totalSlides > 3
                }
            },
            navText: [
                '<i class="fa fa-chevron-left"></i>',
                '<i class="fa fa-chevron-right"></i>'
            ],
            onInitialized: function() {
                // Ensure all cards have equal height after initialization
                setTimeout(function() {
                    $('.promo-carousel .owl-item').css('height', 'auto');
                }, 100);

                // Hide navigation and dots if disabled
                if (totalSlides <= 3) {
                    $('.promo-carousel .owl-nav').addClass('disabled');
                    $('.promo-carousel .owl-dots').addClass('disabled');
                }
            },
            onResized: function() {
                // Re-adjust heights on resize
                setTimeout(function() {
                    $('.promo-carousel .owl-item').css('height', 'auto');
                }, 100);
            }
        });
    }
});

// Handle promo claiming with login check
function handleClaimPromo(promoCode, promoId) {
    // Check if user is logged in (using Laravel's auth check)
    @auth
        // User is logged in, redirect to services page with promo code
        window.location.href = '{{ route("services") }}?promo=' + promoCode;
    @else
        // User is not logged in, show login modal
        if (document.getElementById('openLoginModalBtn')) {
            document.getElementById('openLoginModalBtn').click();
        } else {
            // Fallback: redirect to login page
            window.location.href = '{{ route("login") }}';
        }
    @endauth
}

// Toggle promo services visibility
function togglePromoServices(promoId) {
    var additionalServices = $('#additional-services-' + promoId);
    var moreToggle = $('[data-promo-id="' + promoId + '"].more-services-toggle');
    var lessToggle = $('[data-promo-id="' + promoId + '"].show-less-toggle');

    if (additionalServices.is(':visible')) {
        // Collapse: hide additional services and show "more" link
        additionalServices.slideUp(300);
        moreToggle.show();
        lessToggle.hide();
    } else {
        // Expand: show additional services and hide "more" link
        additionalServices.slideDown(300);
        moreToggle.hide();
        lessToggle.show();
    }
}
</script>
@endsection
