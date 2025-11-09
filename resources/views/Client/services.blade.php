@extends('layouts.clientapp')

@section('content')
<div class="container py-5 mt-5">
	<h2 class="mb-4 text-center" style="color:#F56289;">Professional Beauty & Wellness Solutions</h2>
	<!-- Category Filter Buttons -->
	<div class="mb-4 row">
		<div class="col-12">
			<div class="text-center category_filter">
				<button class="mx-1 filter_btn btn btn-outline-pink active" data-category="all">All Services</button>
				@foreach($categories as $category)
					<button class="mx-1 filter_btn btn btn-outline-pink" data-category="{{ strtolower(str_replace(' ', '-', $category)) }}">{{ $category }}</button>
				@endforeach
			</div>
		</div>
	</div>
	<div id="services-container">
		@foreach($categories as $category)
		@php $catId = strtolower(str_replace(' ', '-', $category)); @endphp
		<div class="mb-5 category-section" id="{{ $catId }}-section">
			<div class="mb-3 category-header">
				<h3 class="mb-1" style="color:#F56289;">{{ $category }}</h3>
				<p class="mb-2">Browse our {{ strtolower($category) }} treatments</p>
				<p class="mb-3 text-muted" style="font-size:0.9rem;">
					<i class="fas fa-arrow-left"></i> Scroll to see more <i class="fas fa-arrow-right"></i>
				</p>
			</div>
			<div class="services-carousel">
				<div class="flex-row gap-4 carousel-container owl-carousel owl-theme d-flex flex-nowrap" id="carousel-{{ $catId }}">
					@foreach($services->where('category', $category)->whereNotNull('treatment_details')->whereNotNull('image')->unique('name') as $service)
					@php
						$serviceSlug = strtolower(str_replace(' ', '-', $service->name));

						// Map ALL service slugs to their correct images
						$imageMap = [
							// Facial Services
							'hydrafacial' => 'hydrafacial.png',
							'diamond-peel-with-complete-facial' => 'Diamond peel.jpg',
							'acne-laser-+-acne-facial' => 'Acne laser + Acne Facial.jpg',
							'microneedling' => 'Acne Treatment.jpg',
							'pigmentation-laser-+-facial' => 'pigmentation.png',
							'skin-rejuvenation-laser-+-facial' => 'Skin Rejuvenation Laser + Facial.jpg',
							'skin911-complete-facial' => 'complete.png',
							'wart-removal-(face-and-neck)' => 'Wart removal (face and neck).jpg',
							'hifu-ultralift' => 'HIFU Ultralift.jpg',

							// Immuno Boosters
							'cindella-drip' => 'Cinderella Drip Treatment.jpg',
							'collagen-injection' => 'Collagen Injection.jpg',
							'elea-white-drip' => 'Elea White Treatment.jpg',
							'immuno-gold-+-vitamin-c' => 'Immuno Gold + Vitamin C Treatment.jpg',
							'luminous-white-drip' => 'Luminous White Drip Treatment.jpg',
							'placenta-injection' => 'Placenta Injection.jpg',

							// Permanent Hair Removal
							  'beard' => 'beard.png',
                                'bikini' => 'bikini.png',
                                'chest/back' => 'chest.png',
                                'full-arms' => 'fullarms.png',
                                'full-brazilian' => 'wax.png',
                                'full-face' => 'fullface.png',
                                'full-legs' => 'fulllegs.png',
                                'half-legs' => 'halflegs.png',
                                'mustache' => 'mus.png',
                                'mustache-&-beard' => 'full.png',
                                'underarms' => 'Underarm whitening.jpg',

							// Slimming Services
							'diode-lipo-laser' => 'Diode Lipo Laser.jpg',
							'lipo-cavitation-+-rf' => 'Lipo Cavitation + RF.jpg',
							'lipo-cavitation' => 'Lipo-cavitation.jpg',
							'radio-frequency-rf' => 'Radio frequency RF.jpg',
							'trio-slim' => 'TRIO slim.jpg',
						];

						// Get correct image or fallback to database image
						$correctImage = isset($imageMap[$serviceSlug])
							? '/img/services/' . $imageMap[$serviceSlug]
							: $service->image;
					@endphp
					<div class="service-card" data-service="{{ $serviceSlug }}" style="width:320px;min-width:320px;max-width:320px;border-radius:16px;position:relative;">
						<div class="service-image"
							 style="border-radius:16px 16px 0 0;overflow:hidden;width:100%;height:160px;background-image:url('{{ asset($correctImage) }}');background-size:cover;background-position:center;">
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
							<p style="font-size:0.95rem;line-height:1.4;word-break:break-word;margin-bottom:0.5rem;">{{ $service->treatment_details }}</p>
							@if($service->benefits)
							<ul>
								@foreach(explode(',', $service->benefits) as $benefit)
								<li>{{ trim($benefit) }}</li>
								@endforeach
							</ul>
							@endif
							<div class="gap-2 mt-3 booking-actions d-flex justify-content-center">
								<a href="{{ route('client.booking') }}?service_id={{ $service->id }}" class="book-now-btn btn btn-pink btn-sm">Book Now</a>
								<a href="#" class="consultation-btn back-btn btn btn-outline-secondary btn-sm">Back</a>
							</div>
						</div>
					</div>
					@endforeach
				</div>
					<!-- nav arrows removed: using native scroll on desktop and swipe on mobile -->
			</div>
		</div>
		@endforeach
	</div>
	@if($services->count() == 0)
		<div class="row">
			<div class="text-center col-12">
				<h3>Coming Soon</h3>
				<p>We're working on bringing you amazing services. Please check back later.</p>
			</div>
		</div>
	@endif
</div>

	{{-- External CSS and JS for client services page --}}
	<link rel="stylesheet" href="{{ asset('css/client/services.css') }}">
	<script src="{{ asset('js/client/services.js') }}" defer></script>
@endsection
