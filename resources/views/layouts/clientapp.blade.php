<!doctype html>
<html class="no-js" lang="zxx">
<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title></title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no">
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
	<!-- Client app layout styles - handles header, navigation, and mobile -->
	<link rel="stylesheet" href="{{ asset('css/client/layouts/clientapp.css') }}?v={{ time() }}">

	<!-- SweetAlert2 -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</head>
<body>
	<!-- Modern Header Start -->
	<header class="modern-header">
		<div class="header-container">
			<div class="header-content">
				<!-- Left Section: Logo -->
				<div class="logo-section">
					<a href="{{ route('home') }}" class="logo-link">
						<img src="{{ asset('img/skinlogo.png') }}" alt="Skin911 Logo" class="logo-img">
					</a>
				</div>

				<!-- Middle Section: Desktop Navigation -->
				<nav class="desktop-nav">
					<ul class="nav-menu">
						<li class="nav-item">
							<a href="{{ route('client.home') }}" class="nav-link {{ Request::routeIs('client.home') ? 'active' : '' }}">
								<i class="fas fa-home"></i>
								<span>Home</span>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('client.dashboard') }}" class="nav-link {{ Request::routeIs('client.dashboard') ? 'active' : '' }}">
								<i class="fas fa-th-large"></i>
								<span>Dashboard</span>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('client.services') }}" class="nav-link {{ Request::routeIs('client.services') ? 'active' : '' }}">
								<i class="fas fa-spa"></i>
								<span>Services</span>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('client.booking') }}" class="nav-link {{ Request::routeIs('client.booking') ? 'active' : '' }}">
								<i class="fas fa-calendar-check"></i>
								<span>Booking</span>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('client.calendar') }}" class="nav-link {{ Request::routeIs('client.calendar') ? 'active' : '' }}">
								<i class="fas fa-calendar-alt"></i>
								<span>Calendar</span>
							</a>
						</li>
					<li class="nav-item">
						<a href="{{ route('client.messages') }}" class="nav-link {{ Request::routeIs('client.messages') ? 'active' : '' }}">
							<i class="fas fa-comments"></i>
							<span>Messages</span>
							<span class="message-notification-badge" id="messageNotificationBadge" style="display: none;">0</span>
						</a>
					</li>
				</ul>
			</nav>				<!-- Right Section: User Info & Actions -->
				<div class="header-actions">
					@auth
					<!-- Notification Dropdown -->
					<div class="dropdown">
						<button class="notification-btn dropdown-toggle" id="notificationBtn" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Notifications">
							<i class="fas fa-bell"></i>
                            <span class="notification-badge" id="notificationBadge" style="display: none;">0</span>
						</button>
						<div class="dropdown-menu notification-dropdown" aria-labelledby="notificationBtn" style="width: 350px; max-height: 500px; overflow-y: auto;">
							<div class="notification-header dropdown-header" style="position: sticky; top: 0; background: white; z-index: 1;">
								<h6 class="mb-0"><i class="fas fa-bell"></i> Notifications</h6>
							</div>
							<div class="notification-content" id="notificationContent" style="max-height: 350px; overflow-y: auto;">
								<div class="notification-empty dropdown-item text-center">
									<i class="fas fa-bell-slash fa-2x text-muted mb-2"></i>
									<p class="mb-1">No notifications yet</p>
									<small class="text-muted">You'll see your booking updates and messages here</small>
								</div>
								<!-- Dynamic notifications will be populated here -->
								{{-- @foreach($notifications ?? [] as $notification)
									<div class="notification-item dropdown-item {{ $notification->read ? '' : 'unread' }}">
										<div class="notification-icon">
											<i class="fas fa-{{ $notification->icon ?? 'bell' }}"></i>
										</div>
										<div class="notification-content">
											<div class="notification-title">{{ $notification->title }}</div>
											<div class="notification-message">{{ $notification->message }}</div>
											<div class="notification-time">{{ $notification->created_at->diffForHumans() }}</div>
										</div>
									</div>
								@endforeach --}}
							</div>
							<div class="dropdown-divider"></div>
							<div class="dropdown-item text-center">
								<button id="markAllRead" class="btn btn-sm btn-outline-primary mr-2">
									<i class="fas fa-check-double"></i> Mark All as Read
								</button>
								
							</div>
						</div>
					</div>

					<!-- Profile Button (Clickable to Edit Profile) -->
					<a href="{{ route('client.profile.edit') }}" class="profile-btn" title="Edit Profile">
						<div class="user-avatar">
							<i class="fas fa-user"></i>
						</div>
						<span class="user-name">{{ Auth::user()->name }}</span>
					</a>

					<!-- Logout Button -->
					<form method="POST" action="{{ route('logout') }}" style="display: inline;">
						@csrf
						<button type="submit" class="logout-btn" title="Logout">
							<i class="fas fa-sign-out-alt"></i>
							<span>Logout</span>
						</button>
					</form>
					@endauth

					<!-- Mobile Menu Button -->
					<button class="mobile-menu-btn" id="mobileMenuBtn" aria-label="Menu">
						<span></span>
						<span></span>
						<span></span>
					</button>
				</div>
			</div>
		</div>

		<!-- Mobile Drawer -->
		<div class="mobile-drawer-overlay" id="mobileOverlay"></div>
		<div class="mobile-drawer" id="mobileDrawer">
			<div class="mobile-drawer-header">
				@auth
				<a href="{{ route('client.profile.edit') }}" class="mobile-user-profile-link">
					<div class="mobile-user-profile">
						<div class="mobile-user-avatar">
							<i class="fas fa-user"></i>
						</div>
						<div class="mobile-user-info">
							<h3>{{ Auth::user()->name }}</h3>
							<p>{{ Auth::user()->email }}</p>
						</div>
						<i class="fas fa-chevron-right profile-arrow"></i>
					</div>
				</a>
				@endauth
			</div>
			<nav class="mobile-drawer-nav">
				<a href="{{ route('client.home') }}" class="mobile-nav-link {{ Request::routeIs('client.home') ? 'active' : '' }}">
					<i class="fas fa-home"></i>
					<span>Home</span>
				</a>
				<a href="{{ route('client.dashboard') }}" class="mobile-nav-link {{ Request::routeIs('client.dashboard') ? 'active' : '' }}">
					<i class="fas fa-th-large"></i>
					<span>Dashboard</span>
				</a>
				<a href="{{ route('client.services') }}" class="mobile-nav-link {{ Request::routeIs('client.services') ? 'active' : '' }}">
					<i class="fas fa-spa"></i>
					<span>Services</span>
				</a>
				<a href="{{ route('client.booking') }}" class="mobile-nav-link {{ Request::routeIs('client.booking') ? 'active' : '' }}">
					<i class="fas fa-calendar-check"></i>
					<span>Booking</span>
				</a>
				<a href="{{ route('client.calendar') }}" class="mobile-nav-link {{ Request::routeIs('client.calendar') ? 'active' : '' }}">
					<i class="fas fa-calendar-alt"></i>
					<span>Calendar</span>
				</a>
				<a href="{{ route('client.messages') }}" class="mobile-nav-link {{ Request::routeIs('client.messages') ? 'active' : '' }}">
					<i class="fas fa-comments"></i>
					<span>Messages</span>
				</a>
			</nav>
			@auth
			<div class="mobile-drawer-footer">
				<form method="POST" action="{{ route('logout') }}">
					@csrf
					<button type="submit" class="mobile-logout-btn">
						<i class="fas fa-sign-out-alt"></i>
						<span>Logout</span>
					</button>
				</form>
			</div>
			@endauth
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
			<input type="file" id="chatImageInput" accept="image/jpeg,image/jpg,image/png,image/gif,image/webp,image/bmp,image/svg+xml,image/heic,image/heif" style="display: none;">
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
							<p class="footer_text"> Banilad, Mandaue City, Cebu </p>
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
	<!-- Chat widget styles -->
	<link rel="stylesheet" href="{{ asset('css/client/chat-widget.css') }}">
	<script>
	// Store current user ID for message notification
	window.currentUserId = {{ Auth::id() }};

	// Message notification system
	@auth
	window.checkForUnreadMessages = function() {
		fetch('/client/messages/new?since=0')
			.then(response => {
				// Check if response is ok (status 200-299)
				if (!response.ok) {
					throw new Error('Route not found or server error');
				}
				return response.json();
			})
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
				// Silently fail - don't spam console with errors
				// This prevents the error from breaking other JavaScript
				console.debug('Message notification system not available:', error.message);
			});
	};

	// Check for unread messages on page load
	document.addEventListener('DOMContentLoaded', function() {
		// Only check if not on messages page
		if (!window.location.pathname.includes('/client/messages')) {
			// Add a small delay to ensure the page is fully loaded first
			setTimeout(function() {
				window.checkForUnreadMessages();
				// Check every 30 seconds
				setInterval(window.checkForUnreadMessages, 30000);
			}, 1000);
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

		// Listen for push notifications (subscribe to Pusher channel)
		const channel = window.pusher.subscribe('user-' + window.authUser.id);

		// Register service worker for push notifications
		if ('serviceWorker' in navigator && 'PushManager' in window) {
			navigator.serviceWorker.register('{{ asset('sw.js') }}')
				.then(function(registration) {
					console.log('Service Worker registered successfully:', registration);

					// Request notification permission
					return Notification.requestPermission();
				})
				.then(function(permission) {
					if (permission === 'granted') {
						console.log('Notification permission granted');
					} else {
						console.log('Notification permission denied');
					}
				})
				.catch(function(error) {
					console.error('Service Worker registration failed:', error);
				});
		} else {
			console.warn('Service Worker or Push Manager not supported');
		}

		// Notification Sidebar Functionality
		window.notifications = [];

		// Load notifications from database on page load
		window.loadNotifications = function() {
			console.log('Loading notifications from database...');
			console.log('Auth user:', window.authUser);

			if (!window.authUser || !window.authUser.id) {
				console.log('No authenticated user, skipping notification load');
				return;
			}

			// Add timeout to prevent indefinite loading
			const controller = new AbortController();
			const timeoutId = setTimeout(() => controller.abort(), 5000); // 5 second timeout

			fetch('/api/notifications', {
				// Use 'include' to send cookies even if slightly different origin (localhost vs 127.0.0.1)
				credentials: 'include',
				headers: {
					'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
					'Accept': 'application/json',
					'Content-Type': 'application/json'
				},
				signal: controller.signal
			})
			.then(response => {
				clearTimeout(timeoutId); // Clear timeout on success
				console.log('API response status:', response.status);
				if (response.status === 401) {
					// Helpful debug info for 401: log cookies and auth user to help identify why session isn't sent/recognized
					try {
						console.error('API returned 401. document.cookie:', document.cookie);
						console.error('window.authUser:', window.authUser);
					} catch (e) {
						console.error('Error while logging debug cookies/authUser:', e);
					}
				}
				if (!response.ok) {
					throw new Error('HTTP error! status: ' + response.status);
				}
				return response.json();
			})
			.then(data => {
				console.log('API response data:', data);
				if (data.success) {
					window.notifications = data.notifications.map(notification => ({
						id: notification.id,
						title: notification.title,
						message: notification.message,
						type: notification.type,
						read: notification.read,
						booking_id: notification.booking_id,
						timestamp: new Date(notification.created_at)
					}));
					console.log('Loaded notifications:', window.notifications);
					console.log('Number of notifications:', window.notifications.length);
					window.updateNotificationUI();
					window.updateNotificationBadge();
				} else {
					console.error('API returned success=false:', data);
					// Still update UI even if no notifications
					window.updateNotificationUI();
					window.updateNotificationBadge();
				}
			})
			.catch(error => {
				clearTimeout(timeoutId); // Clear timeout on error
				console.error('Failed to load notifications:', error);
				if (error.name === 'AbortError') {
					console.error('Notification request timed out after 5 seconds');
				}
				// Show empty state even on error
				window.updateNotificationUI();
				window.updateNotificationBadge();
			});
		};

		// Save notification to database
		window.saveNotification = function(title, message, type = 'info', bookingId = null) {
			return fetch('/api/notifications', {
				credentials: 'include',
				method: 'POST',
				headers: {
					'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
					'Accept': 'application/json',
					'Content-Type': 'application/json'
				},
				body: JSON.stringify({
					title: title,
					message: message,
					type: type,
					booking_id: bookingId
				})
			})
			.then(response => response.json())
			.then(data => {
				if (data.success) {
					// Add to local notifications array
					const notification = {
						id: data.notification.id,
						title: title,
						message: message,
						type: type,
						read: false,
						booking_id: bookingId,
						timestamp: new Date(data.notification.created_at)
					};
					window.notifications.unshift(notification);
					window.updateNotificationUI();
					window.updateNotificationBadge();
					return notification;
				}
			})
			.catch(error => {
				console.error('Failed to save notification:', error);
			});
		};

		// Add notification to the sidebar (now saves to database)
		window.addNotification = function(title, message, type = 'info', bookingId = null) {
			// Save to database first
			return window.saveNotification(title, message, type, bookingId);
		};

		// Update notification badge
	window.updateNotificationBadge = function() {
		const unreadCount = window.notifications.filter(n => !n.read).length;
		const badge = document.getElementById('notificationBadge');
		const navBadge = document.getElementById('navNotificationBadge');

		if (unreadCount > 0) {
			const displayCount = unreadCount > 99 ? '99+' : unreadCount;
			badge.textContent = displayCount;
			badge.style.display = 'inline';

			// Update navigation menu badge
			if (navBadge) {
				navBadge.textContent = displayCount;
				navBadge.style.display = 'inline';
			}
		} else {
			badge.style.display = 'none';
			if (navBadge) {
				navBadge.style.display = 'none';
			}
		}
	};		// Update notification UI
		window.updateNotificationUI = function() {
			console.log('Updating notification UI with', window.notifications.length, 'notifications');
			const container = document.getElementById('notificationContent');

			if (!container) {
				console.error('Notification content container not found');
				return;
			}

			if (window.notifications.length === 0) {
				container.innerHTML = `
					<div class="notification-empty dropdown-item text-center" style="padding: 20px;">
						<i class="fas fa-bell-slash fa-2x text-muted mb-2"></i>
						<p class="mb-1">No notifications yet</p>
						<small class="text-muted">You'll see your booking updates and messages here</small>
					</div>
				`;
				return;
			}

			const notificationsHtml = window.notifications.map(notification => {
				const timeAgo = window.getTimeAgo(notification.timestamp);
				const formattedDate = window.getFormattedDate(notification.timestamp);
				const iconClass = window.getNotificationIcon(notification.type);
				const unreadClass = notification.read ? '' : 'unread';

				return `
					<div class="notification-item dropdown-item ${unreadClass}" data-id="${notification.id}" onclick="window.handleNotificationClick(${notification.id})" style="cursor: pointer; white-space: normal; padding: 15px;">
						<div class="d-flex">
							<div class="notification-icon mr-3">
								<i class="${iconClass}"></i>
							</div>
							<div class="notification-content flex-grow-1">
								<div class="notification-title font-weight-bold">${notification.title}</div>
								<div class="notification-message text-muted small">${notification.message}</div>
								<div class="notification-date text-muted small mt-1">${formattedDate} • ${timeAgo}</div>
							</div>
						</div>
					</div>
				`;
			}).join('');

			container.innerHTML = notificationsHtml;
			console.log('Notification UI updated with HTML');
		};

		// Get notification icon based on type
		window.getNotificationIcon = function(type) {
			const icons = {
				'success': 'fas fa-check-circle text-success',
				'error': 'fas fa-exclamation-circle text-danger',
				'warning': 'fas fa-exclamation-triangle text-warning',
				'info': 'fas fa-info-circle text-info'
			};
			return icons[type] || 'fas fa-bell text-primary';
		};

		// Get time ago string
		window.getTimeAgo = function(date) {
			const now = new Date();
			const diff = now - new Date(date);
			const minutes = Math.floor(diff / 60000);
			const hours = Math.floor(diff / 3600000);
			const days = Math.floor(diff / 86400000);

			if (minutes < 1) return 'Just now';
			if (minutes < 60) return `${minutes}m ago`;
			if (hours < 24) return `${hours}h ago`;
			return `${days}d ago`;
		};

		// Get formatted date string
		window.getFormattedDate = function(date) {
			const notificationDate = new Date(date);
			const today = new Date();
			const yesterday = new Date(today);
			yesterday.setDate(today.getDate() - 1);

			// Check if it's today
			if (notificationDate.toDateString() === today.toDateString()) {
				return 'Today';
			}
			// Check if it's yesterday
			else if (notificationDate.toDateString() === yesterday.toDateString()) {
				return 'Yesterday';
			}
			// Return formatted date
			else {
				return notificationDate.toLocaleDateString('en-US', {
					month: 'short',
					day: 'numeric',
					year: notificationDate.getFullYear() !== today.getFullYear() ? 'numeric' : undefined
				});
			}
		};

		// Handle notification click - mark as read and redirect to specific booking in dashboard
		window.handleNotificationClick = function(id) {
			// Find the notification
			const notification = window.notifications.find(n => n.id === id);
			if (!notification) return;

			// Mark as read in database if not already read
			if (!notification.read) {
					fetch(`/api/notifications/${id}/read`, {
						credentials: 'include',
						method: 'PATCH',
						headers: {
							'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
							'Accept': 'application/json',
							'Content-Type': 'application/json'
						}
					})
				.then(response => response.json())
				.then(data => {
					if (data.success) {
						notification.read = true;
						window.updateNotificationUI();
						window.updateNotificationBadge();
					}
				})
				.catch(error => {
					console.error('Failed to mark notification as read:', error);
				});
			}

			// Redirect to dashboard with booking highlight parameter
			const bookingId = notification.booking_id;
			if (bookingId) {
				window.location.href = '{{ route("client.dashboard") }}?highlight=' + bookingId;
			} else {
				window.location.href = '{{ route("client.dashboard") }}';
			}
		};

		// Mark notification as read (for other uses)
		window.markAsRead = function(id) {
			const notification = window.notifications.find(n => n.id === id);
			if (notification && !notification.read) {
					fetch(`/api/notifications/${id}/read`, {
						credentials: 'include',
						method: 'PATCH',
						headers: {
							'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
							'Accept': 'application/json',
							'Content-Type': 'application/json'
						}
					})
				.then(response => response.json())
				.then(data => {
					if (data.success) {
						notification.read = true;
						window.updateNotificationUI();
						window.updateNotificationBadge();
					}
				})
				.catch(error => {
					console.error('Failed to mark notification as read:', error);
				});
			}
		};

		// Mark all notifications as read
		window.markAllAsRead = function() {
			fetch('/api/notifications/mark-all-read', {
				credentials: 'include',
				method: 'POST',
				headers: {
					'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
					'Accept': 'application/json',
					'Content-Type': 'application/json'
				}
			})
			.then(response => response.json())
			.then(data => {
				if (data.success) {
					// Mark all local notifications as read
					window.notifications.forEach(n => n.read = true);
					window.updateNotificationUI();
					window.updateNotificationBadge();
				}
			})
			.catch(error => {
				console.error('Failed to mark all notifications as read:', error);
			});
		};

		// Enhanced notification listener with sidebar integration
		channel.bind('notification', function(data) {
			// Server already saved to database, just reload notifications to get the latest
			window.loadNotifications();

			// Show browser notification if permission granted
			if (Notification.permission === 'granted') {
				new Notification(data.title || 'Notification', {
					body: data.message || 'You have a new notification',
					icon: data.icon || '{{ asset('img/skinlogo.png') }}'
				});
			}

			// Also show in-app notification using SweetAlert
			Swal.fire({
				title: data.title || 'Notification',
				text: data.message || 'You have a new notification',
				icon: data.type || 'info',
				toast: true,
				position: 'top-end',
				showConfirmButton: false,
				timer: 5000,
				timerProgressBar: true
			});
		});
	</script>

	<script>
		// Notification Dropdown Event Handlers
		document.addEventListener('DOMContentLoaded', function() {
			console.log('DOM loaded, initializing notification handlers...');
			const markAllRead = document.getElementById('markAllRead');

			// Mark all as read
			if (markAllRead) {
				markAllRead.addEventListener('click', function() {
					window.markAllAsRead();
				});
			}

			// Load notifications from database
			if (window.authUser && window.authUser.id) {
				console.log('User is authenticated, loading notifications...');
				window.loadNotifications();
			} else {
				console.log('User not authenticated, skipping notification load');
			}

			// Also reload notifications when the bell button is clicked (refresh before showing dropdown)
			const notifBtn = document.getElementById('notificationBtn');
			if (notifBtn) {
				notifBtn.addEventListener('click', function() {
					console.log('Notification bell clicked - refreshing notifications');
					// Small delay to allow dropdown to open visually, but refresh immediately
					window.loadNotifications();
				});
			}
		});
	</script>

	<script src="{{ asset('js/client/chat-widget.js') }}"></script>
	@endauth
	<script src="{{ asset('js/client/simple-header.js') }}"></script>
	<script src="{{ asset('js/main.js') }}"></script>

	<!-- Push Notification Registration -->
	@auth
	<script>
		// Register service worker for push notifications
		if ('serviceWorker' in navigator && 'PushManager' in window) {
			navigator.serviceWorker.register('/sw.js')
				.then(function(registration) {
					console.log('Service Worker registered successfully:', registration);

					// Request permission for notifications
					return Notification.requestPermission();
				})
				.then(function(permission) {
					if (permission === 'granted') {
						console.log('Notification permission granted');
						// Here you can subscribe to push notifications
						// For now, we'll handle subscription when sending notifications from server
					} else {
						console.log('Notification permission denied');
					}
				})
				.catch(function(error) {
					console.log('Service Worker registration failed:', error);
				});
		} else {
			console.log('Push notifications not supported');
		}
	</script>
	@endauth

	@yield('scripts')
	{{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}
	{{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}
</body>
</html>
