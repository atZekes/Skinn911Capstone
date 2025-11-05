<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use App\Models\Branch;
use App\Events\MessageSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ChatMessageController extends Controller
{
    /**
     * Display the messages page with chat history grouped by branch
     */
    public function index()
    {
        $user = Auth::user();

        // Get all branches where user has chat messages, with latest message
        $chatHistory = ChatMessage::with(['branch', 'staff', 'user'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('branch_id')
            ->map(function ($messages) {
                $branch = $messages->first()->branch;
                $latestMessage = $messages->first();
                $unreadCount = $messages->where('sender_type', 'staff')
                                       ->where('is_read', false)
                                       ->count();

                return [
                    'branch' => $branch,
                    'latest_message' => $latestMessage,
                    'unread_count' => $unreadCount,
                    'message_count' => $messages->count()
                ];
            })
            ->values();

        return view('Client.messages', compact('chatHistory'));
    }

    /**
     * Send a new chat message
     */
    public function sendMessage(Request $request)
    {
        // Debug CSRF and session
        Log::info('ChatMessage sendMessage called', [
            'csrf_token_from_request' => $request->header('X-CSRF-TOKEN'),
            'csrf_token_from_session' => session()->token(),
            'session_id' => session()->getId(),
            'user_id' => Auth::id(),
            'user_authenticated' => Auth::check()
        ]);

        $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'message' => 'nullable|string|max:1000',
            'sender_type' => 'required|in:client,staff',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,bmp,svg,heic,heif|max:10240' // Max 10MB, support multiple formats
        ]);

        // Require either message or image (but not necessarily both)
        if (empty($request->message) && !$request->hasFile('image')) {
            return response()->json([
                'success' => false,
                'message' => 'Either message text or image is required'
            ], 422);
        }

        $user = Auth::user();
        $imagePath = null;

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            
            // Ensure directory exists
            $uploadPath = public_path('chat_images');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            
            // Store directly in public/chat_images/ to avoid symlink issues
            try {
                $image->move($uploadPath, $imageName);
                $imagePath = 'chat_images/' . $imageName;
            } catch (\Exception $e) {
                Log::error('Image upload failed: ' . $e->getMessage());
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to upload image'
                ], 500);
            }
        }        $chatMessage = ChatMessage::create([
            'user_id' => $request->sender_type === 'client' ? $user->id : null,
            'staff_id' => $request->sender_type === 'staff' ? $user->id : null,
            'branch_id' => $request->branch_id,
            'message' => $request->message,
            'image' => $imagePath,
            'sender_type' => $request->sender_type,
            'is_read' => false
        ]);

        // Load relationships for response
        $chatMessage->load(['user', 'staff', 'branch']);

        // Add full image URL for proper display
        if ($chatMessage->image) {
            $chatMessage->image_url = asset($chatMessage->image);
        }

        // Broadcast event for real-time updates
        broadcast(new MessageSent($chatMessage))->toOthers();

        return response()->json([
            'success' => true,
            'message' => 'Message sent successfully',
            'data' => $chatMessage
        ]);
    }

    /**
     * Get chat messages for a specific branch
     */
    public function getMessages(Request $request)
    {
        $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'limit' => 'nullable|integer|min:1|max:100'
        ]);

        $user = Auth::user();
        $limit = $request->input('limit', 50);

        // Get messages for this branch where user is involved
        $query = ChatMessage::with(['user', 'staff', 'branch'])
            ->where('branch_id', $request->branch_id)
            ->orderBy('created_at', 'asc');

        // Filter by user if they're a client
        if ($user->role === 'client') {
            $query->where('user_id', $user->id);
        }

        $messages = $query->limit($limit)->get();

        // Add full image URLs to all messages
        $messages->each(function ($message) {
            if ($message->image) {
                $message->image_url = asset($message->image);
            }
        });

        return response()->json([
            'success' => true,
            'data' => $messages
        ]);
    }

    /**
     * Mark messages as read
     */
    public function markAsRead(Request $request)
    {
        $request->validate([
            'message_ids' => 'required|array',
            'message_ids.*' => 'exists:chat_messages,id'
        ]);

        ChatMessage::whereIn('id', $request->message_ids)
            ->update(['is_read' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Messages marked as read'
        ]);
    }

    /**
     * Get unread message count (for staff)
     */
    public function getUnreadCount(Request $request)
    {
        $user = Auth::user();

        if ($user->role === 'client') {
            // For clients, count unread messages from staff
            $count = ChatMessage::where('user_id', $user->id)
                ->where('sender_type', 'staff')
                ->where('is_read', false)
                ->count();
        } else {
            // For staff, count unread messages from clients in their branch
            $count = ChatMessage::where('branch_id', $user->branch_id)
                ->where('sender_type', 'client')
                ->where('is_read', false)
                ->count();
        }

        return response()->json([
            'success' => true,
            'count' => $count
        ]);
    }

    /**
     * Get all active chats for staff
     */
    public function getActiveChats(Request $request)
    {
        $user = Auth::user();

        if (!in_array($user->role, ['staff', 'admin', 'ceo'])) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Get distinct users who have chatted with this branch
        $chats = ChatMessage::with(['user', 'branch'])
            ->where('branch_id', $user->branch_id)
            ->select('user_id', 'branch_id')
            ->selectRaw('MAX(created_at) as last_message_at')
            ->selectRaw('SUM(CASE WHEN is_read = 0 AND sender_type = "client" THEN 1 ELSE 0 END) as unread_count')
            ->groupBy('user_id', 'branch_id')
            ->orderBy('last_message_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $chats
        ]);
    }
}
