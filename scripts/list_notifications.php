<?php
require_once __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Notification;

$total = Notification::count();
echo "Total notifications: {$total}\n\n";
$notifications = Notification::latest()->take(20)->get();
if ($notifications->isEmpty()) {
    echo "No notifications found.\n";
    exit(0);
}

foreach ($notifications as $n) {
    echo "[{$n->id}] user_id={$n->user_id} read=" . ($n->read ? '1' : '0') . " type={$n->type} title={$n->title} created_at={$n->created_at}\n";
}
