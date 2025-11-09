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


    <!-- about_area_start -->
    <div class="about_area">
        <div class="container">
            <div class="row">
                <div class="col-xl-5 col-lg-5">
                    <div class="about_info">
                        <div class="section_title mb-20px">
                            <span>About Us</span>
                            <h3>Discover Your Best Skin</h3>
                        </div>
                        <p>Skin 911 Facial and Slimming Centre is Cebu's leading skin clinic for your basic skin care and slimming needs. Now with over 23 active branches nationwide,
                            we promise nothing but value for your money with our affordable quality services.</p>

                    </div>
                </div>
                <div class="col-xl-7 col-lg-7">
                    <div class="about_thumb d-flex">
                        <div class="img_1">
                            <img src="img/about/skin6.jpg" alt="">
                        </div>
                        <div class="img_2">
                            <img src="img/about/skin7.jpg" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- about_area_end -->

    <!-- about_info_area_start -->
    <div class="about_info_area">
        <div class="container">
                        <div class="row align-items-center">
                <div class="col-xl-4 col-lg-4">
                    <div class="about_text_content">
                        <div class="section_title mb-20px">
                            <span>Our Expertise</span>
                            <h3>We Provide Advanced and Rejuvenating Skincare</h3>
                        </div>
                        <p>We are dedicated to offering exceptional and effective beauty solutions. Our team of skilled professionals utilizes advanced techniques and premium products to address your unique skincare needs.
                             From revitalizing facials to innovative body contouring, we are committed to helping you achieve visible, lasting results and feel your absolute best.</p>

                        <div class="mt-4 section_title mb-20px">
                            <h3>Experience Premier Aesthetic Treatments</h3>
                        </div>
                        <p>Discover the potential of your skin with our wide array of services. We blend expert care with state-of-the-art technology to deliver personalized treatments that truly make a difference.
                             Whether you wish to refresh your appearance, target specific concerns, or simply indulge in self-care, trust us to provide a professional and renewing experience.</p>
                    </div>
                </div>
                <div class="col-xl-8 col-lg-8">
                    <div class="about_active owl-carousel">

                        <div class="single_slider about_bg_3"></div>
                        <div class="single_slider about_bg_4"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- about_info_area_end -->

    <!-- forQuery_start -->
    <div class="forQuery">
        <div class="container">
            <div class="row">
                <div class="col-xl-10 offset-xl-1 col-md-12">
                    <div class="Query_border">
                        <div class="row align-items-center justify-content-center">
                            <div class="col-xl-6 col-md-6">
                                <div class="Query_text">
                                        <p>For Reservation</p>
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
            <img src="img/instragram/1.png" alt="">
            <div class="ovrelay">
                <a href="#">
                    <i class="fa fa-instagram"></i>
                </a>
            </div>
        </div>
        <div class="single_instagram">
            <img src="img/instragram/2.png" alt="">
            <div class="ovrelay">
                <a href="#">
                    <i class="fa fa-instagram"></i>
                </a>
            </div>
        </div>
        <div class="single_instagram">
            <img src="img/instragram/3.png" alt="">
            <div class="ovrelay">
                <a href="#">
                    <i class="fa fa-instagram"></i>
                </a>
            </div>
        </div>
        <div class="single_instagram">
            <img src="img/instragram/4.png" alt="">
            <div class="ovrelay">
                <a href="#">
                    <i class="fa fa-instagram"></i>
                </a>
            </div>
        </div>
        <div class="single_instagram">
            <img src="img/instragram/5.png" alt="">
            <div class="ovrelay">
                <a href="#">
                    <i class="fa fa-instagram"></i>
                </a>
            </div>
        </div>
    </div>
    <!-- instragram_area_end -->
@section('scripts')
    <script src="{{ asset('js/frontend/aboutus.js') }}"></script>
@endsection
