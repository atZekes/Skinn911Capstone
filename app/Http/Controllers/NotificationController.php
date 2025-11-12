<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Http\JsonResponse;

class NotificationController extends Controller
{
    /**
     * Get all notifications for the authenticated user.
     */
    public function index(Request $request): JsonResponse
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $notifications = Notification::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($notification) {
                return [
                    'id' => $notification->id,
                    'title' => $notification->title,
                    'message' => $notification->message,
                    'type' => $notification->type,
                    'read' => $notification->read,
                    'booking_id' => $notification->booking_id,
                    'created_at' => $notification->created_at,
                    'updated_at' => $notification->updated_at,
                ];
            });

        return response()->json([
            'success' => true,
            'notifications' => $notifications
        ]);
    }

    /**
     * Store a new notification.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'required|in:success,error,warning,info',
            'booking_id' => 'nullable|integer|exists:bookings,id',
            'data' => 'nullable|array'
        ]);

        $notification = auth()->user()->notifications()->create([
            'title' => $validated['title'],
            'message' => $validated['message'],
            'type' => $validated['type'],
            'booking_id' => $validated['booking_id'] ?? null,
            'read' => false,
        ]);

        return response()->json([
            'success' => true,
            'notification' => [
                'id' => $notification->id,
                'title' => $notification->title,
                'message' => $notification->message,
                'type' => $notification->type,
                'read' => false,
                'booking_id' => $notification->booking_id,
                'created_at' => $notification->created_at,
                'updated_at' => $notification->updated_at,
            ]
        ], 201);
    }

    /**
     * Mark a notification as read.
     */
    public function markAsRead(Request $request, Notification $notification): JsonResponse
    {
        // Ensure the notification belongs to the authenticated user
        if ($notification->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $notification->read = true;
        $notification->save();

        return response()->json([
            'success' => true,
            'notification' => $notification
        ]);
    }

    /**
     * Mark all notifications as read for the authenticated user.
     */
    public function markAllAsRead(Request $request): JsonResponse
    {
        auth()->user()->notifications()->update(['read' => true]);

        return response()->json([
            'success' => true,
            'message' => 'All notifications marked as read'
        ]);
    }
}
