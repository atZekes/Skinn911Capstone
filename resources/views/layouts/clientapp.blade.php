<!doctype html>
<html class="no-js" lang="zxx">
<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title></title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<!-- Prevent browser caching of client pages after logout -->
	<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
	<meta http-equiv="Pragma" content="no-cache" />
	<meta http-equiv="Expires" content="0" />

	<link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/favicon.png') }}">

	<!-- CSS here -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}">
	<link rel="stylesheet" href="{{ asset('css/magnific-popup.css') }}">
	<link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
	<link rel="stylesheet" href="{{ asset('css/themify-icons.css') }}">
	<link rel="stylesheet" href="{{ asset('css/nice-select.css') }}">
	<link rel="stylesheet" href="{{ asset('css/flaticon.css') }}">
	<link rel="stylesheet" href="{{ asset('css/gijgo.css') }}">
	<link rel="stylesheet" href="{{ asset('css/animate.css') }}">
	<link rel="stylesheet" href="{{ asset('css/slicknav.css') }}">
	<link rel="stylesheet" href="{{ asset('css/style.css') }}">
	<!-- Simple header styles -->
	<link rel="stylesheet" href="{{ asset('css/client/simple-header.css') }}">

	<!-- SweetAlert2 -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</head>
<body>
	<!-- Simple Header Start -->
	<header>
		<div class="header-area">
			<!-- Main header container -->
			<div id="sticky-header" class="main-header-area">
				<div class="container-fluid" style="padding: 0;">
					<!-- Header row with 3 sections -->
					<div class="row align-items-center" style="margin: 0;">

						<!-- Left Section: Logo -->
						<div class="col-xl-3 col-lg-3" style="text-align: left;">
							<div class="logo-container">
								<a href="{{ route('home') }}">
									<img src="{{ asset('img/skinlogo.png') }}" alt="Skin911 Logo" style="max-height: 40px;">
								</a>
								<!-- Mobile hamburger button (hidden on desktop) -->
								<button class="mobile-hamburger" id="mobileMenuBtn" aria-label="Menu">
									<span></span>
									<span></span>
									<span></span>
								</button>
							</div>
						</div>

						<!-- Middle Section: Navigation Menu -->
						<div class="col-xl-6 col-lg-6">
							<!-- Desktop navigation - shows on big screens -->
							<div class="desktop-nav" style="text-align: center;">
								<ul class="nav-list">
									<li><a href="{{ route('client.home') }}" class="nav-link">Home</a></li>
								<li><a href="{{ route('client.dashboard') }}" class="nav-link">Dashboard</a></li>
								<li><a href="{{ route('client.services') }}" class="nav-link">Services</a></li>
								<li><a href="{{ route('client.booking') }}" class="nav-link">Booking</a></li>
								<li><a href="{{ route('client.calendar') }}" class="nav-link">Calendar</a></li>
								<li><a href="{{ route('client.messages') }}" class="nav-link">Messages</a></li>
							</ul>
							</div>

						<!-- Mobile drawer (hidden by default, slides from right) -->
						<div class="mobile-drawer-overlay" id="mobileOverlay"></div>
						<div class="mobile-drawer" id="mobileDrawer">
							<div class="mobile-drawer-header">
								<!-- Close button removed -->
							</div>
							<nav class="mobile-drawer-nav">
								@auth
								<div class="mobile-user-info">
										<i class="fa fa-user"></i>
										<span>{{ Auth::user()->name }}</span>
									</div>
									@endauth
									<a href="{{ route('client.home') }}">Home</a>
									<a href="{{ route('client.dashboard') }}">Dashboard</a>
									<a href="{{ route('client.services') }}">Services</a>
									<a href="{{ route('client.booking') }}">Booking</a>
									<a href="{{ route('client.calendar') }}">Calendar</a>
									<a href="{{ route('client.messages') }}">Messages</a>
									@auth
									<div class="mobile-drawer-footer">
										<form method="POST" action="{{ route('logout') }}">
											@csrf
											<button type="submit" class="mobile-logout-btn">
												<i class="fa fa-sign-out-alt"></i> Logout
											</button>
										</form>
									</div>
									@endauth
								</nav>
							</div>
						</div>

						<!-- Right Section: User Info (desktop only) -->
						<div class="col-xl-3 col-lg-3 desktop-only">
							@auth
							<div class="user-section">
								<div class="user-name">
									<i class="fa fa-user"></i>
									<a href="{{ route('client.profile.edit') }}">{{ Auth::user()->name }}</a>
								</div>
								<div class="logout-section">
									<form method="POST" action="{{ route('logout') }}">
										@csrf
										<button type="submit" class="logout-btn">Logout</button>
									</form>
								</div>
							</div>
							@endauth
						</div>
					</div>
				</div>
			</div>
		</div>
	</header>
	<!-- Header End -->

	<!-- Simple Chat Widget -->
	@auth
	<!-- The round chat icon button -->
	<button class="chat-icon-button" id="chatIconButton">
		<i class="fa fa-comments"></i>
	</button>

	<!-- The chat window (hidden by default) -->
	<div class="chat-window" id="chatWindow">
		<!-- Top bar with title and close button -->
		<div class="chat-header">
			<h3>Chat Support</h3>
			<button class="chat-close-button" id="chatCloseButton">&times;</button>
		</div>

		<!-- Middle area where messages appear -->
		<div class="chat-messages" id="chatMessages">
			<div class="chat-message">
				Welcome! How can we help you today?
			</div>

			<!-- Preset buttons container -->
			<div class="preset-buttons" id="presetButtons">
				<button class="preset-button" data-message="What are your services?">
					💆 View Services
				</button>
				<button class="preset-button" data-message="What are your branch opening hours?">
					� Branch Opening Hours
				</button>
				<button class="preset-button" data-message="I need to talk to staff">
					👤 Talk to Staff
				</button>
			</div>
		</div>

		<!-- Bottom area with input and send button -->
		<div class="chat-input-area">
			<button class="chat-attach-button" id="chatAttachButton" title="Attach image">
				<i class="fa fa-paperclip"></i>
			</button>
			<input type="file" id="chatImageInput" accept="image/*" style="display: none;">
			<input type="text" id="chatMessageInput" placeholder="Type a message...">
			<button class="chat-send-button" id="chatSendButton">Send</button>
		</div>
		<!-- Image preview area -->
		<div class="chat-image-preview" id="chatImagePreview" style="display: none;">
			<div class="preview-content">
				<img id="previewImage" src="" alt="Preview">
				<button class="remove-preview" id="removePreview">&times;</button>
			</div>
		</div>
	</div>
	@endauth

	@yield('content')

	<!-- footer -->
	<footer class="footer">
		<!-- (Your simplified footer without the "Help" section) -->
		<div class="footer_top">
			<div class="container">
				<div class="row">
					<div class="col-xl-3 col-md-6 col-lg-3">
						<div class="footer_widget">
							<h3 class="footer_title">Address</h3>
							<p class="footer_text"> Skin911 Premier - Banilad Town Center </p>
							<a href="#" class="line-button">Get Direction</a>
						</div>
					</div>
					<div class="col-xl-3 col-md-6 col-lg-3">
						<div class="footer_widget">
							<h3 class="footer_title">Contact Us</h3>
							<p class="footer_text">
								<i class="fa fa-phone"></i> 0917 396 3828<br>
								<i class="fa fa-envelope"></i> skin911.mainofc@gmail.com
							</p>
						</div>
					</div>
					<div class="col-xl-4 col-md-6 col-lg-4">
						<div class="footer_widget">
							<h3 class="footer_title">Follow us</h3>
							<div class="socail_links">
								<ul>
									<li>
										<a href="https://www.facebook.com/Skin911Official/" target="_blank">
											<i class="fab fa-facebook-f"></i>
										</a>
									</li>
									<li>
										<a href="https://www.instagram.com/skin911/?hl=en" target="_blank">
											<i class="fab fa-instagram"></i>
										</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="copy-right_text">
			<div class="container">
				<div class="footer_border"></div>
				<div class="row">
					<div class="col-xl-12">
						<p class="text-center copy_right">
							Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved
						</p>
					</div>
				</div>
			</div>
		</div>
	</footer>

	<!-- JS here -->
	<script src="{{ asset('js/vendor/jquery-1.12.4.min.js') }}"></script>
	<script src="{{ asset('js/popper.min.js') }}"></script>
	<script src="{{ asset('js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('js/owl.carousel.min.js') }}"></script>

	@auth
	<!-- BotMan widget (bottom-right) -->
	<link rel="stylesheet" href="{{ asset('css/client/layouts/clientapp.css') }}">
	<link rel="stylesheet" href="{{ asset('css/client/chat-widget.css') }}">
	<script>
	// Store current user ID for message notification
	window.currentUserId = {{ Auth::id() }};

	// Message notification system
	@auth
	window.checkForUnreadMessages = function() {
		fetch('/client/messages/new?since=0')
			.then(response => response.json())
			.then(data => {
				if (data.success && data.count > 0) {
					const badge = document.getElementById('messageNotificationBadge');
					if (badge) {
						badge.textContent = data.count;
						badge.style.display = 'inline';
					}
				}
			})
			.catch(error => {
				console.log('Error checking for unread messages:', error);
			});
	};

	// Check for unread messages on page load
	document.addEventListener('DOMContentLoaded', function() {
		// Only check if not on messages page
		if (!window.location.pathname.includes('/client/messages')) {
			window.checkForUnreadMessages();
			// Check every 30 seconds
			setInterval(window.checkForUnreadMessages, 30000);
		}
	});
	@endauth
	</script>
	<script src="{{ asset('js/client/layouts/clientapp.js') }}"></script>

	<!-- Pusher JS for real-time chat -->
	<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
	<script>
		// Initialize Pusher globally
		window.pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
			cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
			encrypted: true
		});

		// Pass authenticated user info to JavaScript
		window.authUser = {
			id: {{ auth()->id() }},
			name: '{{ auth()->user()->name }}',
			email: '{{ auth()->user()->email }}'
		};
		console.log('Authenticated user:', window.authUser);
	</script>

	<script src="{{ asset('js/client/chat-widget.js') }}"></script>
	@endauth
	<script src="{{ asset('js/client/simple-header.js') }}"></script>
	<script src="{{ asset('js/main.js') }}"></script>
	@yield('scripts')
	<link rel="stylesheet" href="{{ asset('css/app.css') }}">
	<script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>
