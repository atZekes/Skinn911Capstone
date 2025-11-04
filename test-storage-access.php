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
$chatImagesDir = __DIR__ . '/../storage/app/public/chat_images';
if (is_dir($chatImagesDir)) {
    $files = glob($chatImagesDir . '/*');
    $imageFiles = array_filter($files, 'is_file');

    echo "<h3>Available Images:</h3>";
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
}

echo "<br><h3>Next Steps:</h3>";
echo "1. If any URLs show '✅ Working!', your images should now display in chat<br>";
echo "2. Test by sending an image in the chat<br>";
echo "3. If still not working, contact Hostinger support<br>";
echo "<br><strong style='color: red;'>Delete this test file after confirming it works!</strong>";
?>