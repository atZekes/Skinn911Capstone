<?php
/**
 * Image Path Diagnostic Tool
 * Upload this to your public folder on Hostinger to check image paths
 */

echo "<h1>Service Images Diagnostic</h1>";
echo "<h2>Environment: " . (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'Unknown') . "</h2>";

$servicesDir = __DIR__ . '/img/services/';
echo "<h3>Checking directory: {$servicesDir}</h3>";

if (is_dir($servicesDir)) {
    echo "<p style='color:green;'>✓ Services directory exists</p>";

    $images = glob($servicesDir . '*.{jpg,jpeg,png,gif,webp}', GLOB_BRACE);
    echo "<h3>Found " . count($images) . " images:</h3>";
    echo "<ul>";
    foreach ($images as $image) {
        $filename = basename($image);
        $filesize = filesize($image);
        $relativePath = 'img/services/' . $filename;
        echo "<li>";
        echo "<strong>{$filename}</strong> - " . number_format($filesize) . " bytes<br>";
        echo "<img src='/{$relativePath}' style='max-width:200px;max-height:150px;' alt='{$filename}'><br>";
        echo "Path: <code>{$relativePath}</code>";
        echo "</li><br>";
    }
    echo "</ul>";
} else {
    echo "<p style='color:red;'>✗ Services directory does NOT exist!</p>";
    echo "<p>Expected path: {$servicesDir}</p>";

    // Check if img directory exists
    $imgDir = __DIR__ . '/img/';
    if (is_dir($imgDir)) {
        echo "<p style='color:orange;'>⚠ img directory exists but services subdirectory is missing</p>";
        echo "<p>Creating services directory...</p>";
        if (mkdir($servicesDir, 0755, true)) {
            echo "<p style='color:green;'>✓ Services directory created successfully</p>";
        } else {
            echo "<p style='color:red;'>✗ Failed to create services directory</p>";
        }
    } else {
        echo "<p style='color:red;'>✗ img directory does NOT exist!</p>";
    }
}

echo "<hr>";
echo "<h3>Asset URL Test:</h3>";
$testImages = [
    'skin1.jpg',
    'Skin911 Complete Facial.jpg',
    'HydraFacial.jpg'
];

foreach ($testImages as $testImg) {
    $path = "img/services/{$testImg}";
    $fullPath = __DIR__ . '/' . $path;
    echo "<div style='border:1px solid #ccc; padding:10px; margin:10px 0;'>";
    echo "<strong>{$testImg}</strong><br>";
    echo "Relative path: <code>{$path}</code><br>";
    echo "Full path: <code>{$fullPath}</code><br>";
    echo "File exists: " . (file_exists($fullPath) ? "<span style='color:green;'>YES</span>" : "<span style='color:red;'>NO</span>") . "<br>";
    if (file_exists($fullPath)) {
        echo "File size: " . number_format(filesize($fullPath)) . " bytes<br>";
        echo "<img src='/{$path}' style='max-width:300px;' alt='{$testImg}'>";
    }
    echo "</div>";
}
?>
