<?php
/**
 * Test Storage Access After .htaccess Fix
 * Run this to verify if images are accessible
 */

echo "<h2>Storage Access Test</h2>";

$protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http");
$host = $_SERVER['HTTP_HOST'];
$baseUrl = "$protocol://$host";

// Test URLs
$testUrls = [
    "storage/chat_images/" => "$baseUrl/storage/chat_images/",
    "public/storage/chat_images/" => "$baseUrl/public/storage/chat_images/"
];

echo "<h3>Testing Image Access:</h3><br>";

foreach ($testUrls as $name => $url) {
    echo "<strong>$name:</strong><br>";
    echo "<a href='$url' target='_blank'>$url</a><br>";

    // Try to access the URL
    $headers = @get_headers($url);
    if ($headers) {
        $statusCode = explode(' ', $headers[0])[1];
        $statusText = [
            '200' => '✅ Working!',
            '301' => '✅ Working! (Redirect - this is normal)',
            '302' => '✅ Working! (Redirect - this is normal)',
            '403' => '❌ Forbidden (still broken)',
            '404' => '⚠️ Not Found',
            '500' => '❌ Server Error'
        ];
        echo "Status: $statusCode - " . ($statusText[$statusCode] ?? 'Unknown') . "<br>";
    } else {
        echo "❓ Could not check (connection issue)<br>";
    }
    echo "<br>";
}

// Check for actual image files
echo "<h3>Server Directory Check:</h3>";
$currentDir = __DIR__;
echo "Current script location: $currentDir<br>";

$chatImagesDir = __DIR__ . '/../storage/app/public/chat_images';
echo "Looking for chat images at: $chatImagesDir<br>";

if (is_dir($chatImagesDir)) {
    $files = glob($chatImagesDir . '/*');
    $imageFiles = array_filter($files, 'is_file');

    echo "<h3>✅ Found Images Directory!</h3>";
    echo "Found " . count($imageFiles) . " image files<br><br>";

    if (count($imageFiles) > 0) {
        echo "<strong>Test these specific images:</strong><br>";
        foreach (array_slice($imageFiles, 0, 3) as $file) {
            $filename = basename($file);
            $testUrl = "$baseUrl/storage/chat_images/$filename";
            echo "• <a href='$testUrl' target='_blank'>$filename</a><br>";
        }
    }
} else {
    echo "<h3>❌ Chat images directory not found!</h3>";
    echo "This means either:<br>";
    echo "1. Images haven't been uploaded to Hostinger yet<br>";
    echo "2. Directory structure is different on server<br>";
    echo "3. Storage permissions issue<br><br>";

    // Check if storage directory exists at all
    $storageDir = __DIR__ . '/../storage';
    if (is_dir($storageDir)) {
        echo "✅ Storage directory exists<br>";
        $appDir = $storageDir . '/app';
        if (is_dir($appDir)) {
            echo "✅ Storage/app directory exists<br>";
            $publicDir = $appDir . '/public';
            if (is_dir($publicDir)) {
                echo "✅ Storage/app/public directory exists<br>";
                echo "❌ But chat_images subdirectory is missing<br>";
            } else {
                echo "❌ Storage/app/public directory missing<br>";
            }
        } else {
            echo "❌ Storage/app directory missing<br>";
        }
    } else {
        echo "❌ Storage directory missing<br>";
    }
}

echo "<br><h3>Next Steps:</h3>";
echo "<strong>If URLs show '✅ Working! (Redirect - this is normal)':</strong><br>";
echo "1. ✅ .htaccess rewrite is working correctly<br>";
echo "2. Upload your chat image files to Hostinger storage directory<br>";
echo "3. Test by sending an image in the chat<br><br>";

echo "<strong>If images directory is missing:</strong><br>";
echo "1. Upload the entire 'storage' folder to Hostinger<br>";
echo "2. Make sure chat_images directory exists with your images<br>";
echo "3. Re-run this test<br><br>";

echo "<strong>If still getting 403 Forbidden:</strong><br>";
echo "1. Contact Hostinger support to enable storage access<br>";
echo "2. Or ask them to run: <code>php artisan storage:link</code><br><br>";

echo "<strong style='color: red;'>Delete this test file after confirming it works!</strong>";
?>