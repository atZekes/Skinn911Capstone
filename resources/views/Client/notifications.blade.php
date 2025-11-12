@extends('layouts.clientapp')

@section('title', 'Notifications')

@section('content')
<div class="notifications-page">
    <div class="container py-4">
        <!-- Page Header -->
        <div class="page-header mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1">
                        <i class="fas fa-bell text-primary"></i> Notifications
                    </h2>
                    <p class="text-muted mb-0">Stay updated with your booking activities</p>
                </div>
                <div>
                    <button id="markAllReadBtn" class="btn btn-outline-primary">
                        <i class="fas fa-check-double"></i> Mark All as Read
                    </button>
                </div>
            </div>
        </div>

        <!-- Filter Tabs -->
        <ul class="nav nav-tabs mb-4" id="notificationTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button" role="tab" aria-controls="all" aria-selected="true" data-filter="all">
                    <i class="fas fa-list"></i> All <span class="badge bg-secondary ms-1" id="allCount">0</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="unread-tab" data-bs-toggle="tab" data-bs-target="#unread" type="button" role="tab" aria-controls="unread" aria-selected="false" data-filter="unread">
                    <i class="fas fa-envelope"></i> Unread <span class="badge bg-primary ms-1" id="unreadCount">0</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="read-tab" data-bs-toggle="tab" data-bs-target="#read" type="button" role="tab" aria-controls="read" aria-selected="false" data-filter="read">
                    <i class="fas fa-envelope-open"></i> Read <span class="badge bg-success ms-1" id="readCount">0</span>
                </button>
            </li>
        </ul>

        <!-- Notifications List -->
        <div class="notifications-container" id="notificationsContainer">
            <!-- Loading State -->
            <div class="text-center py-5" id="loadingState">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="text-muted mt-2">Loading notifications...</p>
            </div>

            <!-- Empty State -->
            <div class="empty-state text-center py-5" id="emptyState" style="display: none;">
                <i class="fas fa-bell-slash fa-4x text-muted mb-3"></i>
                <h5 class="text-muted">No notifications yet</h5>
                <p class="text-muted">You'll see your booking updates and messages here</p>
            </div>

            <!-- Notifications will be rendered here -->
            <div id="notificationsList"></div>
        </div>
    </div>
</div>

<!-- Notification Detail Modal -->
<div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="notificationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="notificationModalLabel">Notification Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="notificationModalBody">
                <!-- Notification details will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="viewBookingBtn" style="display: none;">
                    <i class="fas fa-calendar"></i> View Booking
                </button>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.notifications-page {
    min-height: 100vh;
    background-color: #f8f9fa;
}

.page-header h2 {
    font-size: 1.75rem;
    font-weight: 600;
    color: #2c3e50;
}

.nav-tabs .nav-link {
    color: #6c757d;
    border: none;
    border-bottom: 2px solid transparent;
    padding: 0.75rem 1.25rem;
}

.nav-tabs .nav-link:hover {
    border-bottom-color: #dee2e6;
}

.nav-tabs .nav-link.active {
    color: #007bff;
    background-color: transparent;
    border-bottom-color: #007bff;
}

.notification-card {
    background: white;
    border-radius: 8px;
    padding: 1.25rem;
    margin-bottom: 1rem;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
    cursor: pointer;
    border-left: 4px solid transparent;
}

.notification-card:hover {
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    transform: translateY(-2px);
}

.notification-card.unread {
    background-color: #f0f8ff;
    border-left-color: #007bff;
}

.notification-card.success {
    border-left-color: #28a745;
}

.notification-card.warning {
    border-left-color: #ffc107;
}

.notification-card.error {
    border-left-color: #dc3545;
}

.notification-card.info {
    border-left-color: #17a2b8;
}

.notification-icon-wrapper {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}

.notification-icon-wrapper.success {
    background-color: #d4edda;
    color: #28a745;
}

.notification-icon-wrapper.warning {
    background-color: #fff3cd;
    color: #ffc107;
}

.notification-icon-wrapper.error {
    background-color: #f8d7da;
    color: #dc3545;
}

.notification-icon-wrapper.info {
    background-color: #d1ecf1;
    color: #17a2b8;
}

.notification-content-wrapper {
    flex: 1;
    padding-left: 1rem;
}

.notification-title {
    font-weight: 600;
    font-size: 1.1rem;
    color: #2c3e50;
    margin-bottom: 0.25rem;
}

.notification-message {
    color: #6c757d;
    font-size: 0.95rem;
    margin-bottom: 0.5rem;
}

.notification-meta {
    display: flex;
    gap: 1rem;
    font-size: 0.85rem;
    color: #999;
}

.notification-time {
    color: #999;
}

.notification-badge {
    display: inline-block;
    padding: 0.25rem 0.5rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 500;
}

.notification-badge.unread {
    background-color: #007bff;
    color: white;
}

.empty-state i {
    opacity: 0.3;
}
</style>
@endpush

@push('scripts')
<script>
let currentFilter = 'all';
let allNotifications = [];

// Load notifications on page load
document.addEventListener('DOMContentLoaded', function() {
    loadPageNotifications();

    // Mark all as read button
    document.getElementById('markAllReadBtn').addEventListener('click', markAllAsRead);
    
    // Attach filter button handlers (use data-filter attributes)
    const filterButtons = document.querySelectorAll('#notificationTabs button[data-filter]');
    filterButtons.forEach(btn => {
        btn.addEventListener('click', function (e) {
            const filter = this.getAttribute('data-filter');
            if (filter) {
                filterNotifications(filter);
            }
        });
    });
});

// Load notifications for the page
function loadPageNotifications() {
    showLoadingState();

    fetch('/api/notifications', {
        // Ensure session cookie is sent even across localhost/127.0.0.1
        credentials: 'include',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            allNotifications = data.notifications;
            updateCounts();
            renderNotifications();
        } else {
            showEmptyState();
        }
    })
    .catch(error => {
        console.error('Failed to load notifications:', error);
        showEmptyState();
    });
}

// Show loading state
function showLoadingState() {
    document.getElementById('loadingState').style.display = 'block';
    document.getElementById('emptyState').style.display = 'none';
    document.getElementById('notificationsList').innerHTML = '';
}

// Show empty state
function showEmptyState() {
    document.getElementById('loadingState').style.display = 'none';
    document.getElementById('emptyState').style.display = 'block';
    document.getElementById('notificationsList').innerHTML = '';
}

// Update notification counts
function updateCounts() {
    const unreadNotifications = allNotifications.filter(n => !n.read);
    const readNotifications = allNotifications.filter(n => n.read);

    document.getElementById('allCount').textContent = allNotifications.length;
    document.getElementById('unreadCount').textContent = unreadNotifications.length;
    document.getElementById('readCount').textContent = readNotifications.length;
}

// Filter notifications
function filterNotifications(filter) {
    currentFilter = filter;
    renderNotifications();
}

// Render notifications based on current filter
function renderNotifications() {
    let filteredNotifications = allNotifications;

    if (currentFilter === 'unread') {
        filteredNotifications = allNotifications.filter(n => !n.read);
    } else if (currentFilter === 'read') {
        filteredNotifications = allNotifications.filter(n => n.read);
    }

    document.getElementById('loadingState').style.display = 'none';

    if (filteredNotifications.length === 0) {
        showEmptyState();
        return;
    }

    document.getElementById('emptyState').style.display = 'none';
    const container = document.getElementById('notificationsList');

    container.innerHTML = filteredNotifications.map(notification => {
        const icon = getNotificationIcon(notification.type);
        const time = formatNotificationTime(notification.created_at);
        const date = formatNotificationDate(notification.created_at);

        return `
            <div class="notification-card ${notification.read ? '' : 'unread'} ${notification.type}"
                 data-id="${notification.id}"
                 onclick="viewNotification(${notification.id})">
                <div class="d-flex align-items-start">
                    <div class="notification-icon-wrapper ${notification.type}">
                        <i class="${icon}"></i>
                    </div>
                    <div class="notification-content-wrapper">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="notification-title mb-0">${notification.title}</h5>
                            ${notification.read ? '' : '<span class="notification-badge unread">NEW</span>'}
                        </div>
                        <p class="notification-message mb-2">${notification.message}</p>
                        <div class="notification-meta">
                            <span><i class="far fa-clock"></i> ${time}</span>
                            <span><i class="far fa-calendar"></i> ${date}</span>
                            ${notification.booking_id ? '<span><i class="fas fa-calendar-check"></i> Booking #' + notification.booking_id + '</span>' : ''}
                        </div>
                    </div>
                </div>
            </div>
        `;
    }).join('');
}

// Get notification icon
function getNotificationIcon(type) {
    const icons = {
        'success': 'fas fa-check-circle',
        'error': 'fas fa-exclamation-circle',
        'warning': 'fas fa-exclamation-triangle',
        'info': 'fas fa-info-circle'
    };
    return icons[type] || 'fas fa-bell';
}

// Format notification time
function formatNotificationTime(dateString) {
    const date = new Date(dateString);
    const now = new Date();
    const diff = now - date;
    const minutes = Math.floor(diff / 60000);
    const hours = Math.floor(diff / 3600000);
    const days = Math.floor(diff / 86400000);

    if (minutes < 1) return 'Just now';
    if (minutes < 60) return `${minutes}m ago`;
    if (hours < 24) return `${hours}h ago`;
    if (days < 7) return `${days}d ago`;

    return date.toLocaleDateString();
}

// Format notification date
function formatNotificationDate(dateString) {
    const date = new Date(dateString);
    const options = { month: 'short', day: 'numeric', year: 'numeric' };
    return date.toLocaleDateString('en-US', options);
}

// View notification details
function viewNotification(notificationId) {
    const notification = allNotifications.find(n => n.id === notificationId);
    if (!notification) return;

    // Mark as read
    markNotificationAsRead(notificationId);

    // Show modal with details
    const modalBody = document.getElementById('notificationModalBody');
    const viewBookingBtn = document.getElementById('viewBookingBtn');

    const icon = getNotificationIcon(notification.type);
    const date = formatNotificationDate(notification.created_at);
    const time = formatNotificationTime(notification.created_at);

    modalBody.innerHTML = `
        <div class="text-center mb-3">
            <div class="notification-icon-wrapper ${notification.type} mx-auto mb-3" style="width: 64px; height: 64px; font-size: 2rem;">
                <i class="${icon}"></i>
            </div>
            <h5>${notification.title}</h5>
        </div>
        <div class="mb-3">
            <p class="mb-0">${notification.message}</p>
        </div>
        <div class="border-top pt-3">
            <small class="text-muted">
                <i class="far fa-clock"></i> ${time} •
                <i class="far fa-calendar"></i> ${date}
                ${notification.booking_id ? ' • <i class="fas fa-calendar-check"></i> Booking #' + notification.booking_id : ''}
            </small>
        </div>
    `;

    // Show/hide view booking button
    if (notification.booking_id) {
        viewBookingBtn.style.display = 'inline-block';
        viewBookingBtn.onclick = () => {
            window.location.href = '{{ route("client.dashboard") }}';
        };
    } else {
        viewBookingBtn.style.display = 'none';
    }

    const modal = new bootstrap.Modal(document.getElementById('notificationModal'));
    modal.show();
}

// Mark notification as read
function markNotificationAsRead(notificationId) {
    fetch(`/api/notifications/${notificationId}/read`, {
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
            // Update local notification
            const notification = allNotifications.find(n => n.id === notificationId);
            if (notification) {
                notification.read = true;
                updateCounts();
                renderNotifications();
            }
        }
    })
    .catch(error => console.error('Failed to mark notification as read:', error));
}

// Mark all notifications as read
function markAllAsRead() {
    if (allNotifications.length === 0) return;

    if (!confirm('Mark all notifications as read?')) return;

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
            // Update all local notifications
            allNotifications.forEach(n => n.read = true);
            updateCounts();
            renderNotifications();

            // Show success message
            alert('All notifications marked as read!');
        }
    })
    .catch(error => console.error('Failed to mark all as read:', error));
}
</script>
@endpush
@endsection
