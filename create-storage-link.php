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

// Debug: Show paths
echo "<strong>Checking paths:</strong><br>";
echo "Target: $target<br>";
echo "Link: $link<br>";
echo "Target exists: " . (is_dir($target) ? "✅ Yes" : "❌ No") . "<br>";
echo "Link exists: " . (file_exists($link) ? "✅ Yes" : "❌ No") . "<br><br>";

// Check if link already exists
if (file_exists($link)) {
    if (is_link($link)) {
        $linkTarget = readlink($link);
        echo "✅ Storage link already exists!<br>";
        echo "Current Target: $linkTarget<br>";
        
        // Verify it points to the correct location
        if ($linkTarget === $target || realpath($linkTarget) === realpath($target)) {
            echo "✅ Link points to correct location!<br>";
        } else {
            echo "⚠️ Link points to wrong location!<br>";
            echo "Attempting to fix...<br>";
            unlink($link);
            if (symlink($target, $link)) {
                echo "✅ Link fixed!<br>";
            } else {
                echo "❌ Failed to fix link. Error: " . error_get_last()['message'] . "<br>";
            }
        }
    } else {
        echo "⚠️ 'public/storage' exists but is not a symbolic link.<br>";
        echo "Type: " . (is_dir($link) ? "directory" : "file") . "<br>";
        echo "Attempting to remove it...<br>";
        
        if (is_dir($link)) {
            // Try to remove directory
            $files = glob($link . '/*');
            foreach ($files as $file) {
                is_dir($file) ? rmdir($file) : unlink($file);
            }
            if (rmdir($link)) {
                echo "✅ Removed old directory<br>";
            } else {
                echo "❌ Failed to remove directory. Please delete 'public/storage' manually.<br>";
            }
        } else {
            if (unlink($link)) {
                echo "✅ Removed old file<br>";
            } else {
                echo "❌ Failed to remove file<br>";
            }
        }
        
        // Try to create symlink after removal
        if (!file_exists($link)) {
            if (symlink($target, $link)) {
                echo "✅ Storage link created successfully!<br>";
            } else {
                $error = error_get_last();
                echo "❌ Failed to create storage link<br>";
                echo "Error: " . ($error ? $error['message'] : 'Unknown error') . "<br>";
            }
        }
    }
} else {
    // Try to create the symbolic link
    echo "Creating new symbolic link...<br>";
    if (symlink($target, $link)) {
        echo "✅ Storage link created successfully!<br>";
        echo "From: $link<br>";
        echo "To: $target<br>";
    } else {
        $error = error_get_last();
        echo "❌ Failed to create storage link<br>";
        echo "Error: " . ($error ? $error['message'] : 'Unknown error') . "<br>";
        echo "<br><strong>Manual Fix Required:</strong><br>";
        echo "Contact Hostinger support and ask them to run:<br>";
        echo "<code>cd " . __DIR__ . " && php artisan storage:link</code><br>";
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
