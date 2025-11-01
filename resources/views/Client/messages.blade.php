@extends('layouts.clientapp')

@section('title', 'My Messages - Skin911')

@section('content')
<div class="container-fluid" style="margin-top: 100px; margin-bottom: 50px; padding-top: 20px;">
    <!-- Welcome Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-lg" style="border-radius: 25px; border: none; background: linear-gradient(135deg, #e75480 0%, #ff8fab 100%); color: white;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="me-3" style="width: 60px; height: 60px; border-radius: 50%; background: rgba(255, 255, 255, 0.2); display: flex; align-items: center; justify-content: center; backdrop-filter: blur(10px);">
                            <i class="fas fa-comments" style="font-size: 28px;"></i>
                        </div>
                        <div>
                            <h2 class="mb-0" style="font-weight: 700; font-size: 2rem;">My Messages</h2>
                            <p class="mb-0" style="opacity: 0.9;">Stay connected with our staff</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($chatHistory->isEmpty())
        <!-- Empty State -->
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm text-center" style="border-radius: 20px; border: none; padding: 3rem;">
                    <div style="width: 100px; height: 100px; margin: 0 auto 2rem; border-radius: 50%; background: linear-gradient(135deg, #e75480 0%, #ff8fab 100%); display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-comment-slash text-white" style="font-size: 48px;"></i>
                    </div>
                    <h4 style="color: #e75480; font-weight: 600; margin-bottom: 1rem;">No Conversations Yet</h4>
                    <p class="text-muted" style="font-size: 1.1rem;">You don't have any messages yet. Use the chat widget to start a conversation with our staff!</p>
                    <button class="btn mt-3" style="background: linear-gradient(135deg, #e75480 0%, #ff8fab 100%); color: white; padding: 12px 30px; border-radius: 25px; font-weight: 600; border: none;" onclick="if(typeof window.openChatWidget === 'function') { window.openChatWidget(); }">
                        <i class="fas fa-comment-dots me-2"></i>Start a Conversation
                    </button>
                </div>
            </div>
        </div>
    @else
        <!-- Messages Grid -->
        <div class="row">
            @foreach($chatHistory as $chat)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="message-card" onclick="openChatWithBranch({{ $chat['branch']->id }}, '{{ $chat['branch']->name }}')">
                        <div class="card-body p-4">
                            <!-- Branch Header -->
                            <div class="d-flex align-items-start mb-3">
                                <div class="branch-avatar">
                                    <i class="fas fa-hospital-alt"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <h5 class="mb-0" style="color: #e75480; font-weight: 700; font-size: 1.1rem;">
                                            {{ $chat['branch']->name }}
                                        </h5>
                                        @if($chat['unread_count'] > 0)
                                            <span class="unread-badge">
                                                {{ $chat['unread_count'] }}
                                            </span>
                                        @endif
                                    </div>
                                    <small class="text-muted">
                                        <i class="far fa-clock"></i>
                                        {{ $chat['latest_message']->created_at->diffForHumans() }}
                                    </small>
                                </div>
                            </div>

                            <!-- Latest Message Preview -->
                            <div class="message-preview-box">
                                <div class="sender-label">
                                    @if($chat['latest_message']->sender_type === 'client')
                                        <i class="fas fa-user me-1"></i>You:
                                    @else
                                        <i class="fas fa-user-nurse me-1"></i>{{ $chat['latest_message']->staff->name ?? 'Staff' }}:
                                    @endif
                                </div>
                                <p class="message-text">
                                    {{ Str::limit($chat['latest_message']->message, 80) }}
                                </p>
                            </div>

                            <!-- Footer -->
                            <div class="message-card-footer">
                                <span class="message-count">
                                    <i class="fas fa-comment-dots me-1"></i>
                                    {{ $chat['message_count'] }} {{ Str::plural('message', $chat['message_count']) }}
                                </span>
                                <span class="view-chat">
                                    View Chat <i class="fas fa-arrow-right ms-1"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<style>
/* Message Card Styles */
.message-card {
    background: white;
    border-radius: 20px;
    border: 2px solid transparent;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
    box-shadow: 0 4px 12px rgba(231, 84, 128, 0.1);
    position: relative;
    overflow: hidden;
}

.message-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 4px;
    background: linear-gradient(135deg, #e75480 0%, #ff8fab 100%);
    transform: scaleX(0);
    transition: transform 0.4s ease;
}

.message-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 32px rgba(231, 84, 128, 0.25);
    border-color: #e75480;
}

.message-card:hover::before {
    transform: scaleX(1);
}

/* Branch Avatar */
.branch-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: linear-gradient(135deg, #e75480 0%, #ff8fab 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 22px;
    margin-right: 15px;
    box-shadow: 0 4px 12px rgba(231, 84, 128, 0.3);
    transition: all 0.3s ease;
}

.message-card:hover .branch-avatar {
    transform: scale(1.1) rotate(5deg);
    box-shadow: 0 6px 16px rgba(231, 84, 128, 0.4);
}

/* Unread Badge */
.unread-badge {
    background: linear-gradient(135deg, #dc3545 0%, #ff4757 100%);
    color: white;
    font-size: 0.75rem;
    font-weight: 700;
    padding: 6px 12px;
    border-radius: 20px;
    box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
    animation: pulse-badge 2s infinite;
    display: inline-block;
}

@keyframes pulse-badge {
    0%, 100% {
        transform: scale(1);
        box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
    }
    50% {
        transform: scale(1.05);
        box-shadow: 0 6px 16px rgba(220, 53, 69, 0.5);
    }
}

/* Message Preview Box */
.message-preview-box {
    background: linear-gradient(135deg, #fff0f5 0%, #ffffff 100%);
    border-left: 4px solid #e75480;
    border-radius: 12px;
    padding: 15px;
    margin-bottom: 15px;
    transition: all 0.3s ease;
}

.message-card:hover .message-preview-box {
    background: linear-gradient(135deg, #ffe8f0 0%, #fff5f8 100%);
    box-shadow: 0 4px 12px rgba(231, 84, 128, 0.1);
}

.sender-label {
    font-weight: 700;
    color: #e75480;
    font-size: 0.9rem;
    margin-bottom: 8px;
}

.message-text {
    color: #6c757d;
    margin: 0;
    line-height: 1.5;
    font-size: 0.95rem;
}

/* Message Card Footer */
.message-card-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 15px;
    border-top: 1px solid rgba(231, 84, 128, 0.1);
}

.message-count {
    color: #6c757d;
    font-size: 0.9rem;
    font-weight: 500;
}

.view-chat {
    color: #e75480;
    font-weight: 600;
    font-size: 0.9rem;
    transition: all 0.3s ease;
}

.message-card:hover .view-chat {
    color: #ff8fab;
    transform: translateX(5px);
}

/* Responsive */
@media (max-width: 768px) {
    .message-card {
        margin-bottom: 20px;
    }
}
</style>

<script>
function openChatWithBranch(branchId, branchName) {
    // Check if chat widget exists
    if (typeof window.openChatWidget === 'function') {
        // Open the chat widget
        window.openChatWidget();

        // Wait a bit for the widget to open, then simulate branch selection
        setTimeout(function() {
            if (typeof window.handleBranchClick === 'function') {
                window.handleBranchClick(branchId, branchName);
            } else {
                console.error('handleBranchClick function not found');
            }
        }, 300);
    } else {
        alert('Chat widget is not available. Please refresh the page and try again.');
    }
}
</script>
@endsection
