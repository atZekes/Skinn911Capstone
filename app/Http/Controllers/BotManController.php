<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\Drivers\DriverManager;
use App\Models\Message;
use App\Models\Branch;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class BotManController extends Controller
{
    /**
     * Check if user is currently connected to staff for personalized conversation
     */
    private function isUserConnectedToStaff($userId)
    {
        if (!$userId) return false;

        try {
            // Check if user has recent staff connection (within last 2 hours)
            $recentConnection = Message::where('user_id', $userId)
                ->where('sender_type', 'bot')
                ->where('message', 'LIKE', '%connected you to%')
                ->where('created_at', '>=', now()->subHours(2))
                ->latest()
                ->first();

            if (!$recentConnection) return false;

            // Check if connection was ended after the connection
            $disconnection = Message::where('user_id', $userId)
                ->where('sender_type', 'staff')
                ->where('message', 'LIKE', '%Staff connection ended%')
                ->where('created_at', '>', $recentConnection->created_at)
                ->latest()
                ->first();

            return $disconnection === null; // Connected if no disconnection after connection
        } catch (\Exception $e) {
            Log::warning('BotMan: failed to check staff connection: '.$e->getMessage());
            return false;
        }
    }

    /**
     * Get the branch the user is connected to
     */
    private function getUserConnectedBranch($userId)
    {
        if (!$userId) return null;

        try {
            $connection = Message::where('user_id', $userId)
                ->where('sender_type', 'bot')
                ->where('message', 'LIKE', '%connected you to%')
                ->where('created_at', '>=', now()->subHours(2))
                ->latest()
                ->first();

            return $connection ? $connection->branch_id : null;
        } catch (\Exception $e) {
            Log::warning('BotMan: failed to get connected branch: '.$e->getMessage());
            return null;
        }
    }

    public function handle(Request $request)
    {
        // Ensure web driver loaded
        DriverManager::loadDriver(\BotMan\Drivers\Web\WebDriver::class);

        $config = [];
        $botman = BotManFactory::create($config);

        // Priority handler: Check if user is connected to staff for direct forwarding
        $botman->hears('.*', function (BotMan $bot) {
            $userId = Auth::id();
            $userMessage = $bot->getMessage()->getText();

            // Skip if it's a bot command or staff connection request
            if (preg_match('/^(help|menu|start|opening|book|prices|branches|connect_staff|connect to staff|staff|branch_hours|connect_branch:)/', strtolower($userMessage))) {
                return false; // Let other handlers process these
            }

            // Check if user is connected to staff
            if ($this->isUserConnectedToStaff($userId)) {
                $branchId = $this->getUserConnectedBranch($userId);

                // Save user message as forwarded to staff with branch specificity
                try {
                    Message::create([
                        'user_id' => $userId,
                        'sender_type' => 'user',
                        'branch_id' => $branchId,
                        'message' => $userMessage,
                        'forwarded_to_staff' => true,
                        'is_read' => false, // Mark as unread for staff notification
                        'staff_notification_sent' => false
                    ]);
                } catch (\Exception $e) {
                    Log::warning('BotMan: failed to save user message for staff: '.$e->getMessage());
                }

                // Only send confirmation message if it's been more than 5 minutes since last bot confirmation
                // or if this is the first message after connection
                $shouldSendConfirmation = false;
                try {
                    $lastBotConfirmation = Message::where('user_id', $userId)
                        ->where('sender_type', 'bot')
                        ->where('message', 'LIKE', '%Message sent to%staff%')
                        ->where('created_at', '>=', now()->subMinutes(5))
                        ->latest()
                        ->first();

                    $shouldSendConfirmation = !$lastBotConfirmation;
                } catch (\Exception $e) {
                    Log::warning('BotMan: failed to check last confirmation: '.$e->getMessage());
                    $shouldSendConfirmation = false; // Default to not sending if there's an error
                }

                if ($shouldSendConfirmation) {
                    // Get branch name for personalized response
                    $branchName = 'our staff';
                    try {
                        if ($branchId) {
                            $branch = Branch::find($branchId);
                            $branchName = $branch ? $branch->name . ' staff' : 'our staff';
                        }
                    } catch (\Exception $e) {
                        Log::warning('BotMan: failed to get branch name: '.$e->getMessage());
                    }

                    $reply = "Message sent to {$branchName}. They will respond to you shortly through this chat.";
                    $bot->reply($reply);

                    // Save bot response
                    try {
                        Message::create([
                            'user_id' => $userId,
                            'sender_type' => 'bot',
                            'branch_id' => $branchId,
                            'message' => $reply,
                        ]);
                    } catch (\Exception $e) {
                        Log::warning('BotMan: failed to save bot response: '.$e->getMessage());
                    }
                }

                return true; // Stop processing other handlers
            }

            return false; // Let other handlers process if not connected to staff
        });

        // Quick menu with buttons (FAQ quick-replies)
        $botman->hears('help|menu|start', function (BotMan $bot) {
            Log::info('BotMan: received help/menu/start trigger', ['text' => $bot->getMessage() ? $bot->getMessage()->getText() : null]);
            $question = \BotMan\BotMan\Messages\Outgoing\Question::create('How can I help you today?')
                ->addButtons([
                    \BotMan\BotMan\Messages\Outgoing\Actions\Button::create('Opening Hours')->value('opening'),
                    \BotMan\BotMan\Messages\Outgoing\Actions\Button::create('Book')->value('book'),
                    \BotMan\BotMan\Messages\Outgoing\Actions\Button::create('Prices')->value('prices'),
                    \BotMan\BotMan\Messages\Outgoing\Actions\Button::create('Connect to Staff')->value('connect_staff'),
                ]);

            // Persist the user trigger
            try {
                $menuText = $bot->getMessage() ? $bot->getMessage()->getText() : 'menu';
                $m = Message::create([
                    'user_id' => Auth::id(),
                    'sender_type' => 'user',
                    'branch_id' => null,
                    'message' => $menuText,
                ]);
                Log::info('BotMan: saved menu trigger', ['id' => $m->id ?? null, 'message' => $menuText]);
            } catch (\Exception $e) { Log::warning('BotMan: failed to save menu trigger: '.$e->getMessage()); }

            $bot->ask($question, function ($answer, $conversation) use ($bot) {
                // If a button payload arrived, answer will contain value
                $payload = method_exists($answer, 'getValue') ? $answer->getValue() : ($answer->getText() ?: '');

                // Persist user's choice
                try { $mu = Message::create(['user_id' => Auth::id(), 'sender_type' => 'user', 'branch_id' => null, 'message' => $payload]); Log::info('BotMan: saved user choice', ['id'=>$mu->id ?? null, 'payload'=>$payload]); } catch (\Exception $e) { Log::warning('BotMan: failed to save user choice: '.$e->getMessage()); }

                if (strtolower($payload) === 'opening' || strtolower($payload) === 'opening hours' || strtolower($payload) === 'hours') {
                    $reply = 'Our studio is open 10:00 AM to 10:00 PM daily.';
                    $bot->reply($reply);
                } elseif (strtolower($payload) === 'book' || strtolower($payload) === 'booking') {
                    $reply = 'To book, please visit: /client/booking';
                    $bot->reply($reply);
                } elseif (strtolower($payload) === 'prices') {
                    $reply = 'Prices vary by service. Visit /client/services for details.';
                    $bot->reply($reply);
                } else {
                    $bot->reply('Sorry, I did not understand that selection. Try typing "help" to see options.');
                }

                try { $mb = Message::create(['user_id' => null, 'sender_type' => 'bot', 'branch_id' => null, 'message' => $reply]); Log::info('BotMan: saved bot reply', ['id'=>$mb->id ?? null, 'reply'=>$reply]); } catch (\Exception $e) { Log::warning('BotMan: failed to save bot reply: '.$e->getMessage()); }
            });
        });

        // Simple FAQ: opening hours — we'll persist both user and bot messages
        $botman->hears('opening|opening hours|hours', function (BotMan $bot) {
            $userMsg = $bot->getMessage()->getText();
            try {
                // Save user message
                Message::create([
                    'user_id' => Auth::id(),
                    'sender_type' => 'user',
                    'branch_id' => null,
                    'message' => $userMsg,
                ]);
            } catch (\Exception $e) {
                Log::warning('BotMan: failed to save user message: ' . $e->getMessage());
            }

            $reply = 'Our studio is open 10:00 AM to 10:00 PM daily.';
            $bot->reply($reply);

            try {
                Message::create([
                    'user_id' => null,
                    'sender_type' => 'bot',
                    'branch_id' => null,
                    'message' => $reply,
                ]);
            } catch (\Exception $e) {
                Log::warning('BotMan: failed to save bot message: ' . $e->getMessage());
            }
        });

        // Book intent
        $botman->hears('book|booking', function (BotMan $bot) {
            $reply = 'To book, please visit: /client/booking';
            $bot->reply($reply);
            try {
                Message::create(['user_id' => null, 'sender_type' => 'bot', 'branch_id' => null, 'message' => $reply]);
            } catch (\Exception $e) { Log::warning('BotMan: failed to save bot message: '.$e->getMessage()); }
        });

        // List branches (show buttons for each branch)
        $botman->hears('branches', function (BotMan $bot) {
            try {
                $branches = Branch::orderBy('name')->get();
            } catch (\Exception $e) {
                Log::warning('BotMan: failed to load branches: '.$e->getMessage());
                $bot->reply('Sorry, I could not load branch information right now.');
                return;
            }

            if ($branches->isEmpty()) {
                $bot->reply('There are no branches available at the moment.');
                return;
            }

            $question = \BotMan\BotMan\Messages\Outgoing\Question::create('Which branch do you mean?')
                ->addButtons(array_map(function($b){
                    return \BotMan\BotMan\Messages\Outgoing\Actions\Button::create($b->name)->value('branch_hours:'.$b->id);
                }, $branches->all()));

            try {
                Message::create(['user_id' => Auth::id(), 'sender_type' => 'user', 'branch_id' => null, 'message' => 'branches']);
            } catch (\Exception $e) { Log::warning('BotMan: failed to save user message: '.$e->getMessage()); }

            $bot->ask($question, function ($answer, $conversation) use ($bot) {
                $payload = method_exists($answer, 'getValue') ? $answer->getValue() : ($answer->getText() ?: '');
                // Delegate to the branch_hours handler by sending the payload back into BotMan
                if ($payload) {
                    $bot->reply('Fetching hours...');
                    // Directly call the branch_hours logic by simulating hears handling via reply
                    // The existing hears below will pick up the payload when sent by the widget, but
                    // to keep the flow inline we'll just process here by extracting id.
                    preg_match('/branch_hours[:_](\d+)/', $payload, $m);
                    $id = $m[1] ?? null;
                    if ($id) {
                        try {
                            $branch = Branch::find($id);
                        } catch (\Exception $e) { $branch = null; }

                        if ($branch) {
                            $hours = trim(html_entity_decode(strip_tags($branch->hours ?? '')));
                            if (!$hours) $hours = 'Opening hours not set for this branch.';
                            $reply = "Opening hours for {$branch->name}: {$hours}";
                            $bot->reply($reply);
                            try { Message::create(['user_id' => null, 'sender_type' => 'bot', 'branch_id' => $branch->id, 'message' => $reply]); } catch (\Exception $e) { Log::warning('BotMan: failed to save bot message: '.$e->getMessage()); }
                            return;
                        }
                        $bot->reply('Sorry, I could not find that branch.');
                        return;
                    }
                }
                $bot->reply('Okay — if you prefer, type the branch name or try again.');
            });
        });

        // Handle payloads like "branch_hours_1" or "branch_hours:1"
        $botman->hears('branch_hours[:_](\d+)', function (BotMan $bot) {
            $text = $bot->getMessage() ? $bot->getMessage()->getText() : '';
            preg_match('/branch_hours[:_](\d+)/', $text, $m);
            $id = $m[1] ?? null;
            if (!$id) {
                $bot->reply('Please tell me which branch you mean.');
                return;
            }

            try {
                $branch = Branch::find($id);
            } catch (\Exception $e) { $branch = null; }

            if (!$branch) {
                $bot->reply('Sorry, I could not find that branch.');
                return;
            }

            $hours = trim(html_entity_decode(strip_tags($branch->hours ?? '')));
            if (!$hours) $hours = 'Opening hours not set for this branch.';

            $reply = "Opening hours for {$branch->name}: {$hours}";
            $bot->reply($reply);
            try { Message::create(['user_id' => null, 'sender_type' => 'bot', 'branch_id' => $branch->id, 'message' => $reply]); } catch (\Exception $e) { Log::warning('BotMan: failed to save bot message: '.$e->getMessage()); }
        });

        // Connect to Staff flow - show branch selection first
        $botman->hears('connect_staff|connect to staff|staff', function (BotMan $bot) {
            try {
                $branches = Branch::orderBy('name')->get();
            } catch (\Exception $e) {
                Log::warning('BotMan: failed to load branches for staff connection: '.$e->getMessage());
                $bot->reply('Sorry, I could not load branch information right now.');
                return;
            }

            if ($branches->isEmpty()) {
                $bot->reply('There are no branches available at the moment.');
                return;
            }

            $question = \BotMan\BotMan\Messages\Outgoing\Question::create('Which branch would you like to connect to?')
                ->addButtons(array_map(function($b){
                    return \BotMan\BotMan\Messages\Outgoing\Actions\Button::create($b->name)->value('connect_branch:'.$b->id);
                }, $branches->all()));

            try {
                Message::create(['user_id' => Auth::id(), 'sender_type' => 'user', 'branch_id' => null, 'message' => 'connect_staff']);
            } catch (\Exception $e) { Log::warning('BotMan: failed to save user message: '.$e->getMessage()); }

            $bot->ask($question, function ($answer, $conversation) use ($bot) {
                $payload = method_exists($answer, 'getValue') ? $answer->getValue() : ($answer->getText() ?: '');

                // Extract branch ID from payload like "connect_branch:1"
                preg_match('/connect_branch:(\d+)/', $payload, $m);
                $branchId = $m[1] ?? null;

                if (!$branchId) {
                    $bot->reply('Please select a branch from the options above.');
                    return;
                }

                try {
                    $branch = Branch::find($branchId);
                } catch (\Exception $e) { $branch = null; }

                if (!$branch) {
                    $bot->reply('Sorry, I could not find that branch.');
                    return;
                }

                // Create a connection confirmation message
                $reply = "Great! I've connected you to {$branch->name}. Our staff will assist you shortly. From now on, your messages will be forwarded directly to our staff team. You can also visit us directly or call for immediate assistance.";
                $bot->reply($reply);

                // Persist the connection
                try {
                    Message::create([
                        'user_id' => Auth::id(),
                        'sender_type' => 'bot',
                        'branch_id' => $branch->id,
                        'message' => $reply
                    ]);
                } catch (\Exception $e) {
                    Log::warning('BotMan: failed to save staff connection message: '.$e->getMessage());
                }
            });
        });

        // Handle direct connect_branch payloads (if sent directly)
        $botman->hears('connect_branch:(\d+)', function (BotMan $bot) {
            $text = $bot->getMessage() ? $bot->getMessage()->getText() : '';
            preg_match('/connect_branch:(\d+)/', $text, $m);
            $branchId = $m[1] ?? null;

            if (!$branchId) {
                $bot->reply('Please tell me which branch you\'d like to connect to.');
                return;
            }

            try {
                $branch = Branch::find($branchId);
            } catch (\Exception $e) { $branch = null; }

            if (!$branch) {
                $bot->reply('Sorry, I could not find that branch.');
                return;
            }

            $reply = "Great! I've connected you to {$branch->name}. Our staff will assist you shortly.";
            $bot->reply($reply);

            try {
                Message::create([
                    'user_id' => Auth::id(),
                    'sender_type' => 'bot',
                    'branch_id' => $branch->id,
                    'message' => $reply
                ]);
            } catch (\Exception $e) {
                Log::warning('BotMan: failed to save staff connection message: '.$e->getMessage());
            }
        });

        // Fallback
        $botman->fallback(function (BotMan $bot) {
            $text = $bot->getMessage()->getText();
            $bot->reply('Sorry, I did not understand. Try: "opening hours", "book", or "connect to staff".');
            try { Message::create(['user_id' => null, 'sender_type' => 'bot', 'branch_id' => null, 'message' => 'Sorry, I did not understand. Try: "opening hours", "book", or "connect to staff".']); } catch (\Exception $e) { Log::warning('BotMan: failed to save bot message: '.$e->getMessage()); }
        });

        $botman->listen();
    }

    /**
     * Check if the current user is connected to staff (API endpoint)
     */
    public function checkStaffConnection()
    {
        try {
            $userId = Auth::id();

            Log::info('CheckStaffConnection called', [
                'user_id' => $userId,
                'authenticated' => Auth::check()
            ]);

            if (!$userId) {
                return response()->json([
                    'connected' => false,
                    'reason' => 'Not authenticated',
                    'debug' => 'No user ID found'
                ]);
            }

            $isConnected = $this->isUserConnectedToStaff($userId);
            $branchId = $isConnected ? $this->getUserConnectedBranch($userId) : null;

            Log::info('CheckStaffConnection result', [
                'user_id' => $userId,
                'connected' => $isConnected,
                'branch_id' => $branchId
            ]);

            return response()->json([
                'connected' => $isConnected,
                'user_id' => $userId,
                'branch_id' => $branchId,
                'debug' => [
                    'auth_check' => Auth::check(),
                    'method_called' => 'checkStaffConnection'
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('CheckStaffConnection error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'connected' => false,
                'error' => 'Internal server error',
                'debug' => $e->getMessage()
            ], 500);
        }
    }
}
