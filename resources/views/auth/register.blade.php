@extends('layouts.app')
@section('content')
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
    <!-- Registration Form Start -->
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Register</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="mb-3 form-group">
                                <label for="name">Name</label>
                                <input id="name" type="text" class="form-control" name="name" required autofocus>
                            </div>
                            <div class="mb-3 form-group">
                                <label for="email">Email</label>
                                <input id="email" type="email" class="form-control" name="email" required>
                            </div>
                            <div class="mb-3 form-group">
                                <label for="password">Password</label>
                                <input id="password" type="password" class="form-control" name="password" required>
                            </div>
                            <div class="mb-3 form-group">
                                <label for="password_confirmation">Confirm Password</label>
                                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
                            </div>

                            <!-- Service Preferences -->
                            <div class="mb-3 form-group">
                                <label class="form-label fw-bold d-flex align-items-center mb-2" style="font-size: 1rem; color: #333;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-star-fill me-2" viewBox="0 0 16 16" style="color: #ff69b4;">
                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                    </svg>
                                    Service Preferences
                                    <span class="text-muted ms-2" style="font-weight: 400; font-size: 0.85rem;">(Optional)</span>
                                </label>
                                <div class="text-muted mb-2" style="font-size: 0.9rem;">
                                    Select the types of services you're interested in
                                </div>
                                @php
                                    $availablePreferences = [
                                        'Facial' => 'bi-emoji-smile',
                                        'Laser' => 'bi-lightning-charge',
                                        'Slimming' => 'bi-heart-pulse',
                                        'Immuno' => 'bi-shield-check',
                                        'Hair Removal' => 'bi-scissors'
                                    ];
                                @endphp
                                <div class="preference-grid-register">
                                    @foreach($availablePreferences as $preference => $icon)
                                        <div class="preference-item-register">
                                            <input
                                                class="preference-checkbox-register"
                                                type="checkbox"
                                                name="preferences[]"
                                                value="{{ $preference }}"
                                                id="pref_{{ Str::slug($preference) }}"
                                            >
                                            <label class="preference-label-register" for="pref_{{ Str::slug($preference) }}">
                                                <i class="bi {{ $icon }}" style="font-size:1.2rem;margin-bottom:4px;"></i>
                                                <span style="font-size:0.85rem;">{{ $preference }}</span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Role selection removed for security: all public registrations are clients -->
                            <button type="submit" class="btn btn-primary w-100">Register</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Registration Form End -->
    <!-- slider_area_start -->
    <div class="slider_area">
        <div class="slider_active owl-carousel">
            <div class="single_slider d-flex align-items-center justify-content-center slider_bg_1">
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
                                    <a href="{{route('login')}}" class="mobile_no">Contact us</a>
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

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // 1. Select the video element from the page
            const video = document.getElementById('scroll-play-video');

            // 2. Create the Intersection Observer
            // The observer will fire a function when the video's visibility changes.
            const observer = new IntersectionObserver((entries) => {
                // The 'entries' array contains an object for each observed element.
                // We only have one, so we can access it directly with entries[0].
                const entry = entries[0];

                // 3. Check if the video is intersecting (visible) on the screen
                if (entry.isIntersecting) {
                    // If it's visible, play the video
                    video.play();
                } else {
                    // If it's not visible, pause the video to save resources
                    video.pause();
                }
            }, {
                // 4. Options for the observer
                // The 'threshold' determines how much of the element must be visible
                // before the function is triggered. 0.5 means 50%.
                threshold: 0.5
            });

            // 5. Tell the observer to start watching the video element
            observer.observe(video);
        });
        </script>

<script>
// Hide navbar at top, show when scrolling down
window.addEventListener('DOMContentLoaded', function() {
    var header = document.querySelector('.header-area');
    var mainHeader = document.querySelector('.main-header-area');
    var lastScrollY = window.scrollY;
    function handleScroll() {
        if (window.scrollY > 50) {
            header.style.display = '';
            mainHeader.classList.add('sticky');
        } else {
            header.style.display = 'none';
            mainHeader.classList.remove('sticky');
        }
    }
    handleScroll();
    window.addEventListener('scroll', handleScroll);
});
</script>

<style>
.preference-grid-register {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
    gap: 10px;
}

.preference-item-register {
    position: relative;
}

.preference-checkbox-register {
    position: absolute;
    opacity: 0;
    cursor: pointer;
}

.preference-label-register {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 12px 8px;
    background: #f8f9fa;
    border: 2px solid #dee2e6;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.3s ease;
    text-align: center;
    min-height: 80px;
}

.preference-label-register:hover {
    border-color: #ff69b4;
    background: #fff5f9;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(255, 105, 180, 0.2);
}

.preference-checkbox-register:checked + .preference-label-register {
    background: linear-gradient(135deg, #ff69b4 0%, #ff1493 100%);
    border-color: #ff69b4;
    color: #fff;
    box-shadow: 0 6px 15px rgba(255, 105, 180, 0.3);
}

.preference-checkbox-register:checked + .preference-label-register i {
    color: #fff;
}

@media (max-width: 576px) {
    .preference-grid-register {
        grid-template-columns: repeat(2, 1fr);
    }
}
</style>

@endsection
