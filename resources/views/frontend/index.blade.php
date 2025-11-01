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
            <div class="single_slider d-flex align-items-center justify-content-center responsive-banner-bg">
                <!-- per-view index styles moved to top of content -->
                <div class="container">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="text-center slider_text">

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
                        <h3>Up to 35% savings on Facial <br>
                            </h3>
                        <ul>
                            <li>Warts removal</li>
                            <li>Hydrafacial</li>
                            <li>Microneedling</li>
                        </ul>
                        <a href="{{ 'services' }}" class="book_now">book now</a>
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
                        <a href="{{ 'services' }}" class="book_now">book now</a>
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
                        <a href="{{ 'services' }}" class="book_now">book now</a>
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
                        <a href="#" class="line-button">Learn More</a>
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
                <div class="room_thumb">
                    <img src="{{ asset('img/services/3.png') }}" alt="">
                    <div class="room_heading d-flex justify-content-between align-items-center">
                        <div class="room_heading_inner">
                            <span>2,999.00 PHP for 8 Sessions</span>
                            <h3>Radio Frequency</h3>
                        </div>
                        <a href="{{ 'services' }}" class="line-button">book now</a>
                    </div>
                </div>
            </div>
            <div class="single_rooms">
                <div class="room_thumb">
                    <img src="{{ asset('img/services/4.png') }}" alt="">
                    <div class="room_heading d-flex justify-content-between align-items-center">
                        <div class="room_heading_inner">
                            <span>1,499.00 PHP for 3+1 sessions</span>
                            <h3>Complete facial treatment</h3>
                        </div>
                        <a href="{{ 'services' }}" class="line-button">book now</a>
                    </div>
                </div>
            </div>
            <div class="single_rooms">
                <div class="room_thumb">
                    <img src="{{ asset('img/services/8.png') }}" alt="">
                    <div class="room_heading d-flex justify-content-between align-items-center">
                        <div class="room_heading_inner">
                            <span>4,999.00 PHP for 10 Sessions</span>
                            <h3>Immuno Gold</h3>
                        </div>
                        <a href="{{ 'services' }}" class="line-button">book now</a>
                    </div>
                </div>
            </div>
            <div class="single_rooms">
                <div class="room_thumb">
                    <img src="{{ asset('img/services/9.png') }}" alt="">
                    <div class="room_heading d-flex justify-content-between align-items-center">
                        <div class="room_heading_inner">
                            <span>7,499.00 PHP for 5 sessions</span>
                            <h3>Celestial White Drip</h3>
                        </div>
                        <a href="{{ 'services' }}" class="line-button">book now</a>
                    </div>
                </div>
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

    <!-- per-view index JS moved to scripts section -->


@endsection

@section('scripts')
<!-- pageshow reload handled in per-view index.js -->
<script src="{{ asset('js/frontend/index.js') }}"></script>
@endsection
