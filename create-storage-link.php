<?php
/**
 * Create Storage Symbolic Link & Fix Permissions
 * 
 * Run this file once on Hostinger to create the storage link and fix permissions
 * Access via: https://yourdomain.com/create-storage-link.php
 * 
 * After running successfully, DELETE this file for security!
 */

echo "<h2>Storage Link & Permissions Fixer</h2>";

// Get the paths
$target = __DIR__ . '/storage/app/public';
$link = __DIR__ . '/public/storage';
$chatImagesDir = __DIR__ . '/storage/app/public/chat_images';

echo "<h3>Step 1: Check Directories</h3>";

// Create chat_images directory if it doesn't exist
if (!is_dir($chatImagesDir)) {
    if (mkdir($chatImagesDir, 0755, true)) {
        echo "✅ Created chat_images directory<br>";
    } else {
        echo "❌ Failed to create chat_images directory<br>";
    }
} else {
    echo "✅ chat_images directory exists<br>";
}

// Set permissions on storage directories
chmod(__DIR__ . '/storage', 0755);
chmod(__DIR__ . '/storage/app', 0755);
chmod(__DIR__ . '/storage/app/public', 0755);
if (is_dir($chatImagesDir)) {
    chmod($chatImagesDir, 0755);
    echo "✅ Set permissions on storage directories (0755)<br>";
}

echo "<h3>Step 2: Create Symbolic Link</h3>";

// Check if link already exists
if (file_exists($link)) {
    if (is_link($link)) {
        echo "✅ Storage link already exists!<br>";
        echo "Target: " . readlink($link) . "<br>";
    } else {
        echo "⚠️ 'public/storage' exists but is not a symbolic link.<br>";
        echo "Attempting to remove it...<br>";
        if (is_dir($link)) {
            rmdir($link);
        } else {
            unlink($link);
        }
        echo "✅ Removed old public/storage<br>";
        
        // Try to create symlink again
        if (symlink($target, $link)) {
            echo "✅ Storage link created successfully!<br>";
        } else {
            echo "❌ Failed to create storage link<br>";
        }
    }
} else {
    // Try to create the symbolic link
    if (symlink($target, $link)) {
        echo "✅ Storage link created successfully!<br>";
        echo "From: $link<br>";
        echo "To: $target<br>";
    } else {
        echo "❌ Failed to create storage link.<br>";
    }
}

echo "<h3>Step 3: Fix File Permissions</h3>";

// Fix permissions on existing images
if (is_dir($chatImagesDir)) {
    $files = glob($chatImagesDir . '/*');
    $count = 0;
    foreach ($files as $file) {
        if (is_file($file)) {
            chmod($file, 0644);
            $count++;
        }
    }
    echo "✅ Fixed permissions on $count image files (0644)<br>";
}

echo "<h3>Step 4: Test Image URLs</h3>";

// Test if storage is accessible
$protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http");
$host = $_SERVER['HTTP_HOST'];

// Test both possible URL structures
echo "<strong>Test these URLs (one should work):</strong><br><br>";
echo "1. With /public/: <a href='$protocol://$host/public/storage/chat_images/' target='_blank'>$protocol://$host/public/storage/chat_images/</a><br>";
echo "2. Without /public/: <a href='$protocol://$host/storage/chat_images/' target='_blank'>$protocol://$host/storage/chat_images/</a><br>";
echo "<br>";
echo "(One of these should show a directory listing or access denied, not 403 Forbidden)<br>";

echo "<h3>Step 5: Check Your .env File</h3>";
echo "Make sure your .env file on Hostinger has:<br>";
echo "<code>APP_URL=$protocol://$host</code><br>";
echo "<br>";

echo "<h3>✅ All Done!</h3>";
echo "<strong style='color: green;'>If one of the test URLs above works, your images should now display correctly!</strong><br><br>";

echo "<strong style='color: red; font-size: 18px;'>⚠️ IMPORTANT: Delete this file now for security!</strong><br>";
echo "<code>Delete: create-storage-link.php</code>";
?>
