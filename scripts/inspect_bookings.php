<?php
require __DIR__ . '/../vendor/autoload.php';
// load .env if possible
if (file_exists(__DIR__ . '/../.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
    $dotenv->safeLoad();
}
function parseEnv($path) {
    if (!file_exists($path)) return [];
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $vars = [];
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        if (!strpos($line, '=')) continue;
        [$k,$v] = explode('=', $line, 2);
        $vars[trim($k)] = trim(trim($v), "\"\' ");
    }
    return $vars;
}

$env = parseEnv(__DIR__ . '/../.env');
$host = getenv('DB_HOST') ?: ($env['DB_HOST'] ?? '127.0.0.1');
$user = getenv('DB_USERNAME') ?: ($env['DB_USERNAME'] ?? 'root');
$pass = getenv('DB_PASSWORD') ?: ($env['DB_PASSWORD'] ?? '');
$db = getenv('DB_DATABASE') ?: ($env['DB_DATABASE'] ?? null);
if (! $db) {
    echo "No DB_DATABASE in env\n";
    exit(1);
}
$argvDate = $argv[1] ?? null;
$argvSlot = $argv[2] ?? null;
if (! $argvDate || ! $argvSlot) {
    echo "Usage: php inspect_bookings.php <date> <time_slot>\nExample: php inspect_bookings.php 2025-09-03 '10:00-11:00'\n";
    exit(1);
}
$mysqli = new mysqli($host, $user, $pass, $db);
if ($mysqli->connect_errno) {
    echo "Connect error: " . $mysqli->connect_error . "\n";
    exit(1);
}
// fetch bookings that start at the given date and slot
$stmt = $mysqli->prepare('SELECT b.*, s.duration AS service_duration, bs.duration AS pivot_duration, b.branch_id FROM bookings b LEFT JOIN services s ON s.id = b.service_id LEFT JOIN branch_service bs ON (bs.service_id = b.service_id AND bs.branch_id = b.branch_id) WHERE b.date = ? AND b.time_slot = ?');
$stmt->bind_param('ss', $argvDate, $argvSlot);
$stmt->execute();
$res = $stmt->get_result();
$rows = $res->fetch_all(MYSQLI_ASSOC);
if (! count($rows)) {
    echo "No bookings for $argvDate $argvSlot\n";
    exit(0);
}
foreach ($rows as $r) {
    $id = $r['id'];
    $branchId = $r['branch_id'];
    $serviceDur = $r['service_duration'] ?? null;
    $pivotDur = $r['pivot_duration'] ?? null;
    $computedDur = 1;
    if ($pivotDur && (int)$pivotDur > 0) $computedDur = (int)$pivotDur;
    elseif ($serviceDur && (int)$serviceDur > 0) $computedDur = (int)$serviceDur;
    // compute required slots
    $required = [$argvSlot];
    try {
        if ($computedDur > 1) {
            [$ss,$se] = explode('-', $argvSlot, 2);
            $startT = new DateTime(trim($ss));
            for ($i = 1; $i < $computedDur; $i++) {
                $s = clone $startT;
                $s->modify("+{$i} hour");
                $e = clone $s; $e->modify('+1 hour');
                $required[] = $s->format('H:i') . '-' . $e->format('H:i');
            }
        }
    } catch (Exception $e) { }
    echo "Booking id={$id} branch={$branchId} walkin='".($r['walkin_name'] ?? '')."' status={$r['status']}\n";
    echo "  service_dur=" . ($serviceDur ?? 'null') . " pivot_dur=" . ($pivotDur ?? 'null') . " computed={$computedDur}\n";
    echo "  required: " . implode(', ', $required) . "\n";
}
$stmt->close();
$mysqli->close();
