<?php
/**
 * Create Storage Symbolic Link
 * 
 * Run this file once on Hostinger to create the storage link
 * Access via: https://yourdomain.com/create-storage-link.php
 * 
 * After running successfully, DELETE this file for security!
 */

// Get the paths
$target = __DIR__ . '/storage/app/public';
$link = __DIR__ . '/public/storage';

// Check if link already exists
if (file_exists($link)) {
    if (is_link($link)) {
        echo "✅ Storage link already exists!<br>";
        echo "Target: " . readlink($link) . "<br>";
    } else {
        echo "⚠️ 'public/storage' exists but is not a symbolic link.<br>";
        echo "Please delete it manually and run this script again.<br>";
    }
    exit;
}

// Check if target directory exists
if (!is_dir($target)) {
    echo "❌ Target directory does not exist: $target<br>";
    echo "Please create the directory first.<br>";
    exit;
}

// Try to create the symbolic link
if (symlink($target, $link)) {
    echo "✅ Storage link created successfully!<br>";
    echo "From: $link<br>";
    echo "To: $target<br>";
    echo "<br>";
    echo "<strong style='color: red;'>⚠️ IMPORTANT: Delete this file now for security!</strong>";
} else {
    echo "❌ Failed to create storage link.<br>";
    echo "<br>";
    echo "<strong>Alternative solution:</strong><br>";
    echo "Contact Hostinger support and ask them to run this command:<br>";
    echo "<code>php artisan storage:link</code><br>";
}
?>
