<?php

// Backup of app/Http/Controllers/ChatController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    // Show the client chat page
    public function index(Request $request)
    {
        // pass branch id if available (client may choose branch)
        $branchId = $request->get('branch_id');
        return view('Client.chat', ['branchId' => $branchId]);
    }

    // Return preset FAQ messages (simple array)
    public function presets()
    {
        $presets = [
            [
                'id' => 1,
                'title' => 'Opening Hours',
                'message' => 'Our studio is open today from 10am to 10pm.',
                'actions' => [
                    ['label' => 'Book an appointment', 'url' => route('client.booking')],
                    ['label' => 'View hairstylists', 'url' => route('client.services')],
                    ['label' => 'View gallery', 'url' => url('/public/gallery')],
                ],
            ],
            [
                'id' => 2,
                'title' => 'Booking Policy',
                'message' => 'Please arrive 10 minutes early. Cancellations within 24 hours are non-refundable.',
                'actions' => [
                    ['label' => 'Book an appointment', 'url' => route('client.booking')],
                ],
            ],
            [
                'id' => 3,
                'title' => 'Payment Methods',
                'message' => 'We accept cash, card, and GCash.',
                'actions' => [
                    ['label' => 'View payment options', 'url' => url('/payments')],
                ],
            ],
            [
                'id' => 4,
                'title' => 'Services',
                'message' => 'Check our Services page for available treatments and durations.',
                'actions' => [
                    ['label' => 'View services', 'url' => route('client.services')],
                ],
            ],
        ];
        return response()->json($presets);
    }

    // Return available branches (id, name) for branch-specific presets
    public function branches()
    {
        $branches = \App\Models\Branch::query()->select(['id','name'])->orderBy('name')->get();
        return response()->json($branches);
    }

    // Return recent messages for the current branch (or all if none)
    public function messages(Request $request)
    {
        $branchId = $request->get('branch_id');
        $query = Message::query()->orderBy('created_at', 'asc');
        if ($branchId) {
            $query->where('branch_id', $branchId);
        }
        // limit to last 200 messages to keep responses small
        $messages = $query->limit(200)->get();
        return response()->json($messages);
    }

    // Send/store a message (from client). Optionally simulate bot response for presets.
    public function send(Request $request)
    {
        $user = Auth::user();
        $text = trim($request->input('message'));
        $branchId = $request->input('branch_id');

        if ($text === '') {
            return response()->json(['error' => 'Empty message'], 422);
        }

        $msg = Message::create([
            'user_id' => $user ? $user->id : null,
            'sender_type' => 'user',
            'branch_id' => $branchId,
            'message' => $text,
        ]);

        // Simple bot: if user message matches a preset title, reply with the preset message
        $lower = strtolower($text);
        $botReply = null;
        if (strpos($lower, 'opening') !== false) {
            $botReply = 'We are open 9:00 AM to 8:00 PM daily.';
        } elseif (strpos($lower, 'booking') !== false) {
            $botReply = 'Please arrive 10 minutes early. Cancellations within 24 hours are non-refundable.';
        } elseif (strpos($lower, 'payment') !== false) {
            $botReply = 'We accept cash, card, and GCash.';
        }

        if ($botReply) {
            $bot = Message::create([
                'user_id' => null,
                'sender_type' => 'bot',
                'branch_id' => $branchId,
                'message' => $botReply,
            ]);
        }

        return response()->json(['status' => 'ok', 'message' => $msg]);
    }

    // Trigger a preset by id: store user message (preset title) and bot reply (preset message)
    public function triggerPreset(Request $request)
    {
        $presetId = (int) $request->input('preset_id');
        $branchId = $request->input('branch_id');
        $user = Auth::user();

        // define the same presets here (small duplication for simplicity)
        $map = [
            1 => ['title' => 'Opening Hours', 'reply' => 'Our studio is open today from 10am to 10pm.'],
            2 => ['title' => 'Booking Policy', 'reply' => 'Please arrive 10 minutes early. Cancellations within 24 hours are non-refundable.'],
            3 => ['title' => 'Payment Methods', 'reply' => 'We accept cash, card, and GCash.'],
            4 => ['title' => 'Services', 'reply' => 'Check our Services page for available treatments and durations.'],
        ];

        if (!isset($map[$presetId])) {
            return response()->json(['error' => 'Preset not found'], 404);
        }

        $preset = $map[$presetId];

        // create user message (as if user clicked preset)
        $userMsg = Message::create([
            'user_id' => $user ? $user->id : null,
            'sender_type' => 'user',
            'branch_id' => $branchId,
            'message' => $preset['title'],
        ]);

        // create bot reply
        $botMsg = Message::create([
            'user_id' => null,
            'sender_type' => 'bot',
            'branch_id' => $branchId,
            'message' => $preset['reply'],
        ]);

        return response()->json(['status' => 'ok', 'user_message' => $userMsg, 'bot_message' => $botMsg]);
    }
}
