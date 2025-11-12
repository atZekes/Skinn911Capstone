@extends('layouts.clientapp')

@section('content')
    <!-- Email Verification Success Message -->
    @if(session('verified') == 1 || request('verified') == 1 || session('success'))
        <div style="position: fixed; top: 80px; right: 20px; z-index: 9999; animation: slideInRight 0.5s ease-out;">
            <div style="background: linear-gradient(135deg, #D4EDDA 0%, #C3E6CB 100%); border: 2px solid #28A745; border-radius: 12px; padding: 20px 25px; box-shadow: 0 8px 25px rgba(40, 167, 69, 0.3); max-width: 400px;">
                <div style="display: flex; align-items: center; gap: 15px;">
                    <i class="fas fa-check-circle" style="font-size: 32px; color: #28A745;"></i>
                    <div>
                        <h4 style="margin: 0 0 5px 0; color: #155724; font-weight: 700;">Email Verified! 🎉</h4>
                        <p style="margin: 0; color: #155724; font-size: 14px;">
                            {{ session('success') ?? 'Your account is now active. Welcome to Skin911!' }}
                        </p>
                    </div>
                    <button onclick="this.parentElement.parentElement.style.display='none'" style="background: transparent; border: none; color: #28A745; font-size: 24px; cursor: pointer; margin-left: auto;">&times;</button>
                </div>
            </div>
        </div>
        <style>
            @keyframes slideInRight {
                from {
                    opacity: 0;
                    transform: translateX(100px);
                }
                to {
                    opacity: 1;
                    transform: translateX(0);
                }
            }
        </style>
        <script>
            // Auto-hide the success message after 8 seconds
            setTimeout(function() {
                var successMsg = document.querySelector('[style*="slideInRight"]');
                if (successMsg) {
                    successMsg.style.opacity = '0';
                    successMsg.style.transition = 'opacity 0.5s';
                    setTimeout(function() {
                        successMsg.style.display = 'none';
                    }, 500);
                }
            }, 8000);
        </script>
    @endif

    <!-- Responsive Banner -->
    @if(request('showLogin'))
        {{-- small flag for client/home.js to pick up and open login modal if present --}}
        <div id="__client_show_login_flag" data-show="1" style="display:none"></div>
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
                        <span>Our Offers</span>
                        <h3>Ongoing Offers</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-4 col-md-4">
                    <div class="single_offers">
                        <div class="about_thumb">
                            <img src="{{ asset('img/skin3.jpg') }}" alt="">
                        </div>
                        <h3>Up to 35% savings on Facial</h3>
                        <ul>
                            <li>Warts removal</li>
                            <li>Hydrafacial</li>
                            <li>Microneedling</li>
                        </ul>
                        <div class="offer-buttons d-flex gap-2 justify-content-center mt-3">
                            <a href="{{ route('client.services') }}" class="btn btn-outline-pink btn-sm">Learn More</a>
                            <a href="{{ route('client.booking') }}" class="btn btn-pink btn-sm">Book Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-4">
                    <div class="single_offers">
                        <div class="about_thumb">
                            <img src="{{ asset('img/skin4.jpg') }}" alt="">
                        </div>
                        <h3>Up to 35% savings on Whitening and Rejuvenation</h3>
                        <ul>
                            <li>Underarm whitening</li>
                            <li>Pigmentation Whitening</li>
                            <li>Skin Rejuvenation</li>
                        </ul>
                        <div class="offer-buttons d-flex gap-2 justify-content-center mt-3">
                            <a href="{{ route('client.services') }}" class="btn btn-outline-pink btn-sm">Learn More</a>
                            <a href="{{ route('client.booking') }}" class="btn btn-pink btn-sm">Book Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-4">
                    <div class="single_offers">
                        <div class="about_thumb">
                            <img src="{{ asset('img/skin5.jpg') }}" alt="">
                        </div>
                        <h3>Up to 35% savings on Slimming</h3>
                        <ul>
                            <li>Redio Frequency</li>
                            <li>Lipo-Cavitation</li>
                            <li>Trio Slim</li>
                        </ul>
                        <div class="offer-buttons d-flex gap-2 justify-content-center mt-3">
                            <a href="{{ route('client.services') }}" class="btn btn-outline-pink btn-sm">Learn More</a>
                            <a href="{{ route('client.booking') }}" class="btn btn-pink btn-sm">Book Now</a>
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
            >
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
                <a href="{{ route('client.services') }}" class="room_thumb_link">
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
                <a href="{{ route('client.services') }}" class="room_thumb_link">
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
                <a href="{{ route('client.services') }}" class="room_thumb_link">
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
                <a href="{{ route('client.services') }}" class="room_thumb_link">
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
                                    @auth
                                        <button onclick="openChat()" class="mobile_no" style="background: #F56289; color: #fff; padding: 12px 53px; border-radius: 30px; display: inline-block; font-size: 18px; border: 1px solid transparent; cursor: pointer; text-decoration: none;">Contact us</button>
                                    @else
                                        <a href="{{ route('contact') }}" class="mobile_no">Contact us</a>
                                    @endauth
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
                <a href="#">
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
    {{-- per-view JS/CSS for client home --}}
    <link rel="stylesheet" href="{{ asset('css/client/home.css') }}">
    <script src="{{ asset('js/client/home.js') }}" defer></script>
@endsection
@section('scripts')
    {{-- keep small inline trigger to open login modal on DOMContentLoaded for backward compatibility --}}
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var flag = document.getElementById('__client_show_login_flag');
        if (flag && flag.dataset.show === '1') {
            // prefer existing global/button trigger if available
            if (typeof openLoginModalBtn !== 'undefined') {
                try { openLoginModalBtn.click(); } catch(e){}
            } else {
                var btn = document.getElementById('openLoginModalBtn');
                if (btn) { try { btn.click(); } catch(e){} }
            }
        }
    });
    </script>

    <style>
        /* Ensure book now buttons are always clickable on mobile */
        @media (max-width: 767px) {
            .book_now, .line-button {
                position: relative;
                z-index: 100 !important;
                pointer-events: auto !important;
                cursor: pointer !important;
                display: inline-block !important;
                touch-action: manipulation;
            }

            .single_offers, .single_rooms {
                position: relative;
                z-index: 10;
            }

            .single_offers a, .single_rooms a {
                position: relative;
                z-index: 100;
                pointer-events: auto;
            }
        }
    </style>
@endsection
