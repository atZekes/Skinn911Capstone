<?php
// Quick diagnostic to check if session cookie is being set
session_start();

header('Content-Type: application/json');

echo json_encode([
    'session_id' => session_id(),
    'session_data' => $_SESSION,
    'cookies' => $_COOKIE,
    'cookie_params' => session_get_cookie_params(),
    'session_name' => session_name(),
]);
