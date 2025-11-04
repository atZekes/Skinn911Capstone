@extends('layouts.staffapp')

@section('styles')
<style>
    .chat-messages {
        background: linear-gradient(to bottom, #f8f9fa, #ffffff);
    }

    .client-message .message-bubble {
        border-bottom-left-radius: 4px !important;
        position: relative;
    }

    .staff-message .message-bubble {
        border-bottom-right-radius: 4px !important;
        position: relative;
    }

    .client-message .message-bubble::before {
        content: '';
        position: absolute;
        bottom: 0;
        left: -8px;
        width: 0;
        height: 0;
        border: 8px solid transparent;
        border-right-color: #ffffff;
        border-bottom: 0;
        border-left: 0;
    }

    .staff-message .message-bubble::before {
        content: '';
        position: absolute;
        bottom: 0;
        right: -8px;
        width: 0;
        height: 0;
        border: 8px solid transparent;
        border-left-color: #e75480;
        border-bottom: 0;
        border-right: 0;
    }

    .message-text {
        word-wrap: break-word;
        line-height: 1.4;
    }

    .customer-item {
        transition: all 0.3s ease;
        border-left: 4px solid transparent;
    }

    .customer-item:hover {
        background-color: rgba(231, 84, 128, 0.1) !important;
        border-color: #e75480 !important;
        transform: translateX(5px);
    }

    .customer-item.active {
        background-color: rgba(231, 84, 128, 0.2) !important;
        border-color: #e75480 !important;
        border-left: 4px solid #e75480;
    }

    .customer-item.has-unread {
        border-left: 4px solid #dc3545;
        background-color: #fff5f5;
    }

    .unread-badge {
        animation: pulse 2s infinite;
        font-weight: bold;
        font-size: 0.75rem;
        padding: 0.35em 0.65em;
        box-shadow: 0 2px 4px rgba(220, 53, 69, 0.3);
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
            box-shadow: 0 2px 4px rgba(220, 53, 69, 0.3);
        }
        50% {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(220, 53, 69, 0.5);
        }
        100% {
            transform: scale(1);
            box-shadow: 0 2px 4px rgba(220, 53, 69, 0.3);
        }
    }

    .notification-icon {
        display: inline-block;
        animation: ring 2s ease-in-out infinite;
        margin-right: 5px;
    }

    @keyframes ring {
        0%, 100% { transform: rotate(0deg); }
        10%, 30% { transform: rotate(-10deg); }
        20% { transform: rotate(10deg); }
    }

    .customer-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #e75480, #ff8fab);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        font-size: 1.2rem;
        margin-right: 12px;
        box-shadow: 0 2px 8px rgba(231, 84, 128, 0.3);
    }

    .message-preview {
        font-size: 0.85rem;
        color: #6c757d;
        margin-top: 5px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .customer-item.has-unread .message-preview {
        color: #495057;
        font-weight: 500;
    }

    /* Toast Notification Styles */
    .message-toast {
        position: fixed;
        top: 80px;
        right: 20px;
        min-width: 350px;
        max-width: 400px;
        background: linear-gradient(135deg, #e75480, #ff8fab);
        color: white;
        padding: 1.2rem 1.5rem;
        border-radius: 12px;
        box-shadow: 0 8px 24px rgba(231, 84, 128, 0.4);
        z-index: 9999;
        animation: slideIn 0.4s ease-out, fadeOut 0.5s ease-in 4.5s;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    @keyframes slideIn {
        from {
            transform: translateX(400px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes fadeOut {
        from {
            opacity: 1;
        }
        to {
            opacity: 0;
            transform: translateX(400px);
        }
    }

    .toast-icon {
        font-size: 2rem;
        animation: bounce 1s infinite;
    }

    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }

    .toast-content h6 {
        margin: 0 0 5px 0;
        font-weight: 600;
        font-size: 1rem;
    }

    .toast-content p {
        margin: 0;
        font-size: 0.9rem;
        opacity: 0.95;
    }

    .toast-close {
        position: absolute;
        top: 10px;
        right: 10px;
        background: rgba(255, 255, 255, 0.3);
        border: none;
        color: white;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        transition: all 0.3s;
    }

    .toast-close:hover {
        background: rgba(255, 255, 255, 0.5);
        transform: rotate(90deg);
    }
</style>
@endsection

@section('tab-content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <h3 style="color: #e75480;">
                <i class="fas fa-users me-2"></i>Customer List
            </h3>
            <div class="list-group" id="customerList">
                @if(isset($customers) && $customers->count() > 0)
                    @foreach($customers as $customer)
                        <a href="#" class="list-group-item list-group-item-action customer-item {{ $customer->unread_count > 0 ? 'has-unread' : '' }}"
                           data-customer-id="{{ $customer->id }}"
                           data-customer-name="{{ $customer->name }}">
                            <div class="d-flex align-items-start">
                                <div class="customer-avatar">
                                    {{ strtoupper(substr($customer->name, 0, 1)) }}
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex w-100 justify-content-between align-items-center">
                                        <h6 class="mb-0">{{ $customer->name }}</h6>
                                        <small class="text-muted">{{ $customer->last_message_at ? $customer->last_message_at->diffForHumans() : 'No messages' }}</small>
                                    </div>
                                    @if($customer->unread_count > 0)
                                        <div class="mt-2">
                                            <span class="notification-icon">🔔</span>
                                            <span class="badge bg-danger unread-badge">{{ $customer->unread_count }} new message{{ $customer->unread_count > 1 ? 's' : '' }}</span>
                                        </div>
                                    @endif
                                    <div class="message-preview mt-1">
                                        <i class="fas fa-comment-dots"></i> {{ $customer->messages_count }} total message{{ $customer->messages_count != 1 ? 's' : '' }}
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                @else
                    <div class="text-center text-muted py-4">
                        <p>No customer interactions yet.</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="col-md-8">
            <div id="chatContainer" class="d-none">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3 style="color: #e75480;">Chat with <span id="customerName"></span></h3>
                </div>

                <div class="chat-messages" id="chatMessages" style="height: 450px; overflow-y: auto; border: 2px solid #e75480; border-radius: 12px; padding: 1.5rem; background: linear-gradient(to bottom, #f8f9fa, #ffffff); box-shadow: inset 0 2px 4px rgba(0,0,0,0.1);">
                    <!-- Messages will be loaded here -->
                </div>

                <div class="mt-3">
                    <form id="replyForm">
                        <input type="hidden" id="customerId" name="customer_id">
                        <div class="d-flex gap-2 align-items-center">
                            <button type="button" class="btn btn-outline-secondary" id="staffAttachButton" title="Attach image" style="padding: 10px 15px;">
                                <i class="fa fa-paperclip"></i>
                            </button>
                            <input type="file" id="staffImageInput" name="image" accept="image/jpeg,image/jpg,image/png,image/gif,image/webp,image/bmp,image/svg+xml,image/heic,image/heif" style="display: none;">
                            <input type="text" class="form-control" id="staffReply" name="message" placeholder="Type your reply..." style="border-color: #e75480; flex: 1;">
                            <button type="submit" class="btn" style="background: #e75480; color: #fff; padding: 10px 20px;">Send</button>
                        </div>
                        <!-- Image preview -->
                        <div id="staffImagePreview" style="display: none; margin-top: 12px; padding: 10px; background: #f8f9fa; border-radius: 8px; border: 1px solid #dee2e6;">
                            <small class="d-block mb-2 text-muted">Image Preview:</small>
                            <div style="position: relative; display: inline-block;">
                                <img id="staffPreviewImage" src="" alt="Preview" style="max-width: 150px; max-height: 150px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); display: block;">
                                <button type="button" id="staffRemovePreview" style="position: absolute; top: -8px; right: -8px; background: #dc3545; color: white; border: none; width: 28px; height: 28px; border-radius: 50%; cursor: pointer; font-size: 18px; line-height: 1; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 4px rgba(0,0,0,0.2);">&times;</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div id="welcomeMessage" class="text-center text-muted py-5">
                <h4>Select a customer to view their messages</h4>
                <p>Choose a customer from the list on the left to start viewing their chat history.</p>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const customerItems = document.querySelectorAll('.customer-item');
    const chatContainer = document.getElementById('chatContainer');
    const welcomeMessage = document.getElementById('welcomeMessage');
    const customerNameSpan = document.getElementById('customerName');
    const chatMessages = document.getElementById('chatMessages');
    const customerId = document.getElementById('customerId');
    const replyForm = document.getElementById('replyForm');

    // Image attachment elements
    const staffAttachButton = document.getElementById('staffAttachButton');
    const staffImageInput = document.getElementById('staffImageInput');
    const staffImagePreview = document.getElementById('staffImagePreview');
    const staffPreviewImage = document.getElementById('staffPreviewImage');
    const staffRemovePreview = document.getElementById('staffRemovePreview');

    // Handle staff image attachment
    if (staffAttachButton) {
        staffAttachButton.addEventListener('click', function() {
            staffImageInput.click();
        });
    }

    if (staffImageInput) {
        staffImageInput.addEventListener('change', function(event) {
            const file = event.target.files[0];

            if (file) {
                // Check if it's a valid image file (support multiple formats)
                const validImageTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp', 'image/bmp', 'image/svg+xml', 'image/heic', 'image/heif'];

                if (!validImageTypes.includes(file.type)) {
                    alert('Please select a valid image file (JPEG, PNG, GIF, WebP, BMP, SVG, HEIC, HEIF).');
                    staffImageInput.value = '';
                    return;
                }

                // Check file size (max 10MB)
                if (file.size > 10 * 1024 * 1024) {
                    alert('Image file is too large. Maximum size is 10MB.');
                    staffImageInput.value = '';
                    return;
                }

                // Show preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    staffPreviewImage.src = e.target.result;
                    staffImagePreview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });
    }

    if (staffRemovePreview) {
        staffRemovePreview.addEventListener('click', function() {
            staffImageInput.value = '';
            staffImagePreview.style.display = 'none';
            staffPreviewImage.src = '';
        });
    }

    // Handle customer selection
    customerItems.forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();

            // Remove active class from all items
            customerItems.forEach(i => i.classList.remove('active'));
            // Add active class to clicked item
            this.classList.add('active');

            const customerIdValue = this.dataset.customerId;
            const customerName = this.dataset.customerName;

            // Update UI
            customerNameSpan.textContent = customerName;
            customerId.value = customerIdValue;
            welcomeMessage.classList.add('d-none');
            chatContainer.classList.remove('d-none');

            // Load messages for this customer
            loadCustomerMessages(customerIdValue);
        });
    });

    // Load customer messages via AJAX
    function loadCustomerMessages(customerIdValue) {
        fetch(`/staff/customer-messages/${customerIdValue}`)
            .then(response => response.json())
            .then(data => {
                chatMessages.innerHTML = '';
                data.messages.forEach(message => {
                    const messageDiv = document.createElement('div');
                    const time = new Date(message.created_at).toLocaleString();

                    // Determine message alignment and styling based on sender
                    let alignment, bgColor, textColor, senderLabel;

                    if (message.sender_type === 'client') {
                        // Client messages - left side
                        alignment = 'start';
                        bgColor = '#ffffff';
                        textColor = '#333';
                        senderLabel = 'Customer';
                        messageDiv.className = 'message mb-3 client-message';
                    } else if (message.sender_type === 'staff') {
                        // Staff messages - right side
                        alignment = 'end';
                        bgColor = '#e75480';
                        textColor = '#fff';
                        senderLabel = 'You';
                        messageDiv.className = 'message mb-3 staff-message';
                    } else {
                        // Bot messages - center or left
                        alignment = 'start';
                        bgColor = '#f8f9fa';
                        textColor = '#333';
                        senderLabel = 'Bot';
                        messageDiv.className = 'message mb-3 bot-message';
                    }

                    // Build message content
                    let messageContent = `
                        <div class="d-flex justify-content-${alignment}">
                            <div class="message-bubble p-3 rounded-3 shadow-sm" style="max-width: 75%; background: ${bgColor}; color: ${textColor};">
                                <small class="d-block mb-2 opacity-75"><strong>${senderLabel}</strong></small>`;

                    // Add text message if available
                    if (message.message) {
                        messageContent += `<div class="message-text">${message.message}</div>`;
                    }

                    // Add image if available
                    if (message.image) {
                        const imageSrc = message.image_url || `/storage/${message.image}`;
                        messageContent += `<img src="${imageSrc}"
                            alt="Attached image"
                            class="message-image"
                            style="max-width: 200px; max-height: 200px; border-radius: 8px; margin-top: 8px; cursor: pointer;"
                            onclick="window.open(this.src, '_blank')">`;
                    }

                    messageContent += `
                                <small class="d-block mt-2 opacity-75 text-end" style="font-size: 0.75rem;">${time}</small>
                            </div>
                        </div>
                    `;

                    messageDiv.innerHTML = messageContent;
                    chatMessages.appendChild(messageDiv);
                });

                // Scroll to bottom
                chatMessages.scrollTop = chatMessages.scrollHeight;
            })
            .catch(error => {
                console.error('Error loading messages:', error);
                chatMessages.innerHTML = '<div class="alert alert-danger">Error loading messages</div>';
            });
    }

    // Handle reply form submission
    let isSubmittingReply = false;
    replyForm.addEventListener('submit', function(e) {
        e.preventDefault();

        const submitBtn = this.querySelector('button[type="submit"]');

        // Prevent double-submit
        if (isSubmittingReply || (submitBtn && submitBtn.disabled)) {
            return false;
        }

        const formData = new FormData(this);
        const customerIdValue = customerId.value;
        const messageValue = document.getElementById('staffReply').value;
        const hasImage = staffImageInput.files.length > 0;

        console.log('Sending reply:', {
            customer_id: customerIdValue,
            message: messageValue,
            has_image: hasImage
        });

        // Check if we have the required data (message or image)
        if (!customerIdValue) {
            alert('Please select a customer first');
            return;
        }

        if (!messageValue.trim() && !hasImage) {
            alert('Please enter a message or attach an image');
            return;
        }

        // Disable submit button
        isSubmittingReply = true;
        const originalBtnText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';

        fetch('/staff/send-reply', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            console.log('Response status:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);
            if (data.success) {
                // Reload messages
                loadCustomerMessages(customerId.value);
                // Clear the input and image preview
                document.getElementById('staffReply').value = '';
                staffImageInput.value = '';
                staffImagePreview.style.display = 'none';
                staffPreviewImage.src = '';
                console.log('Reply sent successfully');
            } else {
                console.error('Server error:', data.message);
                alert('Error sending reply: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error sending reply:', error);
            alert('Error sending reply: ' + error.message);
        })
        .finally(() => {
            // Re-enable submit button
            isSubmittingReply = false;
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnText;
        });
    });

    // ========== REAL-TIME PUSHER UPDATES ==========
    // Initialize Pusher if available
    let currentChannel = null;
    let currentCustomerId = null;

    function initializePusher(customerId, branchId) {
        if (!window.pusher) {
            console.log('Pusher not initialized');
            return;
        }

        // Unsubscribe from previous channel if exists
        if (currentChannel) {
            window.pusher.unsubscribe(currentChannel.name);
        }

        // Subscribe to branch-specific channel
        currentChannel = window.pusher.subscribe(`chat.branch.${branchId}`);
        currentCustomerId = customerId;

        // Listen for new messages
        currentChannel.bind('message.sent', function(data) {
            console.log('Received message via Pusher:', data);

            // Only show message if it's for the current customer and from client
            if (data.user_id == currentCustomerId && data.sender_type === 'client') {
                displayNewMessage(data);

                // Play notification sound
                playNotificationSound();

                // Show toast notification
                showMessageToast(data.user_name || 'Customer', data.message || 'Sent an image');
            } else if (data.sender_type === 'client') {
                // Message from different customer - show toast and update badge
                showMessageToast(data.user_name || 'Customer', data.message || 'Sent an image', data.user_id);
                updateCustomerBadge(data.user_id);
            }
        });

        console.log(`Pusher subscribed to channel: chat.branch.${branchId}`);
    }

    function showMessageToast(customerName, messageText, customerId = null) {
        // Create toast element
        const toast = document.createElement('div');
        toast.className = 'message-toast';
        toast.innerHTML = `
            <div class="toast-icon">💬</div>
            <div class="toast-content flex-grow-1">
                <h6>New Message from ${customerName}</h6>
                <p>${messageText.length > 50 ? messageText.substring(0, 50) + '...' : messageText}</p>
            </div>
            <button class="toast-close" onclick="this.parentElement.remove()">×</button>
        `;

        // Add click handler to navigate to customer
        if (customerId) {
            toast.style.cursor = 'pointer';
            toast.addEventListener('click', function(e) {
                if (e.target.className !== 'toast-close') {
                    const customerLink = document.querySelector(`[data-customer-id="${customerId}"]`);
                    if (customerLink) {
                        customerLink.click();
                    }
                    toast.remove();
                }
            });
        }

        // Add to document
        document.body.appendChild(toast);

        // Remove after 5 seconds
        setTimeout(() => {
            toast.remove();
        }, 5000);
    }

    function updateCustomerBadge(customerId) {
        // Find the customer item and update badge
        const customerItem = document.querySelector(`[data-customer-id="${customerId}"]`);
        if (customerItem) {
            // Add has-unread class
            customerItem.classList.add('has-unread');

            // Update or create badge
            let badgeContainer = customerItem.querySelector('.mt-2');
            if (!badgeContainer) {
                badgeContainer = document.createElement('div');
                badgeContainer.className = 'mt-2';
                const flexGrow = customerItem.querySelector('.flex-grow-1');
                const messagePreview = customerItem.querySelector('.message-preview');
                flexGrow.insertBefore(badgeContainer, messagePreview);
            }

            let badge = badgeContainer.querySelector('.unread-badge');
            if (badge) {
                const currentCount = parseInt(badge.textContent.match(/\d+/)[0]);
                badge.textContent = `${currentCount + 1} new message${currentCount + 1 > 1 ? 's' : ''}`;
            } else {
                badgeContainer.innerHTML = `
                    <span class="notification-icon">🔔</span>
                    <span class="badge bg-danger unread-badge">1 new message</span>
                `;
            }
        }
    }

    function displayNewMessage(messageData) {
        const time = new Date(messageData.created_at).toLocaleString();
        const messageDiv = document.createElement('div');
        messageDiv.className = 'message mb-3 client-message';

        let messageContent = `
            <div class="d-flex justify-content-start">
                <div class="message-bubble p-3 rounded-3 shadow-sm" style="max-width: 75%; background: #ffffff; color: #333; border: 1px solid #dee2e6;">
                    <small class="d-block mb-2 opacity-75"><strong>Customer</strong></small>`;

        // Add text message if available
        if (messageData.message) {
            messageContent += `<div class="message-text">${messageData.message}</div>`;
        }

        // Add image if available
        if (messageData.image) {
            const imageSrc = messageData.image_url || `/storage/${messageData.image}`;
            messageContent += `<img src="${imageSrc}"
                alt="Attached image"
                class="message-image"
                style="max-width: 200px; max-height: 200px; border-radius: 8px; margin-top: 8px; cursor: pointer; display: block;"
                onclick="window.open(this.src, '_blank')">`;
        }

        messageContent += `
                    <small class="d-block mt-2 opacity-75 text-end" style="font-size: 0.75rem;">${time}</small>
                </div>
            </div>
        `;

        messageDiv.innerHTML = messageContent;
        chatMessages.appendChild(messageDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    function playNotificationSound() {
        // Create a simple beep sound
        const audioContext = new (window.AudioContext || window.webkitAudioContext)();
        const oscillator = audioContext.createOscillator();
        const gainNode = audioContext.createGain();

        oscillator.connect(gainNode);
        gainNode.connect(audioContext.destination);

        oscillator.frequency.value = 800;
        oscillator.type = 'sine';

        gainNode.gain.setValueAtTime(0.3, audioContext.currentTime);
        gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.5);

        oscillator.start(audioContext.currentTime);
        oscillator.stop(audioContext.currentTime + 0.5);
    }

    // Update loadCustomerMessages to initialize Pusher
    const originalLoadCustomerMessages = loadCustomerMessages;
    loadCustomerMessages = function(customerIdValue) {
        originalLoadCustomerMessages(customerIdValue);

        // Get branch ID from staff user
        @auth('staff')
        const staffBranchId = {{ auth('staff')->user()->branch_id ?? 'null' }};
        if (staffBranchId) {
            initializePusher(customerIdValue, staffBranchId);
            startAutoRefresh(customerIdValue);
        }
        @endauth
    };

    // ========== AUTO-REFRESH VIA AJAX POLLING ==========
    let refreshInterval = null;
    let lastMessageCount = 0;

    function startAutoRefresh(customerIdValue) {
        // Clear any existing interval
        if (refreshInterval) {
            clearInterval(refreshInterval);
        }

        // Refresh every 5 seconds
        refreshInterval = setInterval(function() {
            refreshMessages(customerIdValue);
        }, 5000);

        console.log('Started auto-refresh for customer:', customerIdValue);
    }

    function refreshMessages(customerIdValue) {
        fetch(`/staff/customer-messages/${customerIdValue}`)
            .then(response => response.json())
            .then(data => {
                if (data.success && data.messages) {
                    // Only update if message count changed
                    if (data.messages.length !== lastMessageCount) {
                        const currentScrollPos = chatMessages.scrollTop;
                        const isScrolledToBottom = chatMessages.scrollHeight - chatMessages.clientHeight <= currentScrollPos + 50;

                        chatMessages.innerHTML = '';
                        data.messages.forEach(message => {
                            const messageDiv = document.createElement('div');
                            const time = new Date(message.created_at).toLocaleString();

                            let alignment, bgColor, textColor, senderLabel;

                            if (message.sender_type === 'client') {
                                alignment = 'start';
                                bgColor = '#ffffff';
                                textColor = '#333';
                                senderLabel = 'Customer';
                                messageDiv.className = 'message mb-3 client-message';
                            } else if (message.sender_type === 'staff') {
                                alignment = 'end';
                                bgColor = '#e75480';
                                textColor = '#fff';
                                senderLabel = 'You';
                                messageDiv.className = 'message mb-3 staff-message';
                            } else {
                                alignment = 'start';
                                bgColor = '#f8f9fa';
                                textColor = '#333';
                                senderLabel = 'Bot';
                                messageDiv.className = 'message mb-3 bot-message';
                            }

                            messageDiv.innerHTML = `
                                <div class="d-flex justify-content-${alignment}">
                                    <div class="message-bubble p-3 rounded-3 shadow-sm" style="max-width: 75%; background: ${bgColor}; color: ${textColor}; ${bgColor === '#ffffff' ? 'border: 1px solid #dee2e6;' : ''}">
                                        <small class="d-block mb-2 opacity-75"><strong>${senderLabel}</strong></small>
                                        <div class="message-text">${message.message}</div>
                                        <small class="d-block mt-2 opacity-75 text-end" style="font-size: 0.75rem;">${time}</small>
                                    </div>
                                </div>
                            `;
                            chatMessages.appendChild(messageDiv);
                        });

                        lastMessageCount = data.messages.length;

                        // Auto-scroll to bottom if user was already at bottom
                        if (isScrolledToBottom) {
                            chatMessages.scrollTop = chatMessages.scrollHeight;
                        }
                    }
                }
            })
            .catch(error => {
                console.error('Error refreshing messages:', error);
            });
    }

    // Stop auto-refresh when switching customers
    customerItems.forEach(item => {
        item.addEventListener('click', function() {
            if (refreshInterval) {
                clearInterval(refreshInterval);
            }
            lastMessageCount = 0;
        });
    });
});
</script>

<!-- Include Pusher JS -->
@auth('staff')
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script>
// Initialize Pusher for staff
if (typeof Pusher !== 'undefined') {
    window.pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
        cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
        forceTLS: true
    });
    console.log('Pusher initialized for staff');
} else {
    console.error('Pusher library not loaded');
}
</script>
@endauth

<style>
.chat-messages {
    background: #fff !important;
}

.message-bubble {
    word-wrap: break-word;
}

.customer-item.active {
    background-color: #e75480 !important;
    color: white !important;
}

.customer-item.active .text-muted {
    color: rgba(255,255,255,0.8) !important;
}
</style>
@endsection
