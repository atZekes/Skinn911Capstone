<?php
/**
 * Create Storage Symbolic Link & Fix Permissions
 * 
 * Run this file once on Hostinger to create the storage link and fix permissions
 * Access via: https://yourdomain.com/create-storage-link.php
 * 
 * After running successfully, DELETE this file for security!
 */

// Helper function to copy directory recursively
function copyDirectory($src, $dst) {
    if (!is_dir($src)) {
        return false;
    }
    
    if (!is_dir($dst)) {
        mkdir($dst, 0755, true);
    }
    
    $dir = opendir($src);
    if (!$dir) {
        return false;
    }
    
    $success = true;
    while (($file = readdir($dir)) !== false) {
        if ($file === '.' || $file === '..') {
            continue;
        }
        
        $srcPath = $src . '/' . $file;
        $dstPath = $dst . '/' . $file;
        
        if (is_dir($srcPath)) {
            $success &= copyDirectory($srcPath, $dstPath);
        } else {
            $success &= copy($srcPath, $dstPath);
            if ($success) {
                chmod($dstPath, 0644);
            }
        }
    }
    
    closedir($dir);
    return $success;
}

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

// Check if symlink function is available
echo "<strong>System Check:</strong><br>";
echo "Symlink function available: " . (function_exists('symlink') ? "✅ Yes" : "❌ No") . "<br>";
echo "Exec function available: " . (function_exists('exec') ? "✅ Yes" : "❌ No") . "<br>";
echo "Safe mode: " . (ini_get('safe_mode') ? "❌ Enabled (may cause issues)" : "✅ Disabled") . "<br><br>";

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
    flush(); // Force output before potentially hanging operation
    
    // Set a timeout for the symlink operation
    $timeout = 10; // 10 seconds timeout
    $startTime = time();
    
    // Try to create symlink with timeout
    $symlinkResult = false;
    $errorMessage = '';
    
    try {
        // Use exec to try creating symlink with timeout
        $command = "ln -s \"$target\" \"$link\" 2>&1";
        $output = [];
        $returnCode = 0;
        
        exec($command, $output, $returnCode);
        
        if ($returnCode === 0 && file_exists($link) && is_link($link)) {
            $symlinkResult = true;
            echo "✅ Storage link created successfully using exec!<br>";
        } else {
            $errorMessage = "Exec failed with code $returnCode: " . implode("\n", $output);
        }
    } catch (Exception $e) {
        $errorMessage = "Exception: " . $e->getMessage();
    }
    
    // If exec failed, try PHP symlink function
    if (!$symlinkResult) {
        echo "Exec method failed, trying PHP symlink function...<br>";
        flush();
        
        // Try PHP symlink with error suppression and timeout
        $symlinkResult = @symlink($target, $link);
        
        if (!$symlinkResult) {
            $error = error_get_last();
            $errorMessage = $error ? $error['message'] : 'Unknown PHP error';
        }
    }
    
    if ($symlinkResult && file_exists($link) && is_link($link)) {
        echo "✅ Storage link created successfully!<br>";
        echo "From: $link<br>";
        echo "To: $target<br>";
    } else {
        echo "❌ Failed to create storage link<br>";
        echo "Error: $errorMessage<br>";
        echo "<br><strong>Alternative Solutions:</strong><br>";
        
        echo "<h4>Option 1: Manual SSH Command (if you have SSH access)</h4>";
        echo "Run this command via SSH:<br>";
        echo "<code>cd " . dirname($link) . " && ln -s \"$target\" storage</code><br><br>";
        
        echo "<h4>Option 2: Copy Files Instead of Symlink</h4>";
        echo "If symlinks are disabled, we can copy the files instead:<br>";
        
        // Try to copy files as alternative
        if (!is_dir($link)) {
            mkdir($link, 0755, true);
        }
        
        $copySuccess = copyDirectory($target, $link);
        if ($copySuccess) {
            echo "✅ Files copied successfully as alternative to symlink!<br>";
            echo "<strong>Note:</strong> You'll need to re-copy files if new images are uploaded.<br>";
        } else {
            echo "❌ File copying also failed<br>";
        }
        
        echo "<h4>Option 3: Contact Hostinger Support</h4>";
        echo "Ask Hostinger to enable symbolic links or run:<br>";
        echo "<code>cd " . __DIR__ . " && php artisan storage:link</code><br><br>";
        
        echo "<h4>Option 4: Use .htaccess Rewrite (Last Resort)</h4>";
        echo "Add this to your public/.htaccess file:<br>";
        echo "<pre>RewriteRule ^storage/(.*)$ ../storage/app/public/$1 [L]</pre><br>";
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

echo "<h3>Step 4: Test Image Access</h3>";

// Test if storage is accessible
$protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http");
$host = $_SERVER['HTTP_HOST'];
$baseUrl = "$protocol://$host";

// Test URLs
$testUrls = [
    "$baseUrl/storage/chat_images/",
    "$baseUrl/public/storage/chat_images/"
];

echo "<strong>Testing image access:</strong><br><br>";

foreach ($testUrls as $index => $url) {
    echo "<strong>Test " . ($index + 1) . ":</strong> <a href='$url' target='_blank'>$url</a><br>";
    
    // Try to access the URL
    $headers = @get_headers($url);
    if ($headers) {
        $statusCode = explode(' ', $headers[0])[1];
        if ($statusCode == '200') {
            echo "✅ Status: $statusCode (Accessible)<br>";
        } elseif ($statusCode == '403') {
            echo "❌ Status: $statusCode (Forbidden - This is the problem!)<br>";
        } elseif ($statusCode == '404') {
            echo "⚠️ Status: $statusCode (Not Found - Link may not be working)<br>";
        } else {
            echo "ℹ️ Status: $statusCode<br>";
        }
    } else {
        echo "❓ Could not check status (connection issue)<br>";
    }
    echo "<br>";
}

// Check if there are any test images
if (is_dir($chatImagesDir)) {
    $files = glob($chatImagesDir . '/*');
    $imageCount = count(array_filter($files, 'is_file'));
    echo "📁 Found $imageCount image files in chat_images directory<br>";
    
    if ($imageCount > 0) {
        echo "<strong>Sample image URLs to test:</strong><br>";
        $sampleFiles = array_slice(array_filter($files, 'is_file'), 0, 3);
        foreach ($sampleFiles as $file) {
            $filename = basename($file);
            echo "• <a href='$baseUrl/storage/chat_images/$filename' target='_blank'>$baseUrl/storage/chat_images/$filename</a><br>";
        }
    }
}

echo "<h3>Step 5: Check Your .env File</h3>";
echo "Make sure your .env file on Hostinger has:<br>";
echo "<code>APP_URL=$protocol://$host</code><br>";
echo "<br>";

echo "<h3>✅ Setup Complete!</h3>";
echo "<strong style='color: green;'>Check the test results above to see if image access is working!</strong><br><br>";

echo "<strong>Next Steps:</strong><br>";
echo "1. Test the chat functionality by sending an image<br>";
echo "2. If images still don't work, try the alternative solutions above<br>";
echo "3. Contact Hostinger support if symlinks are disabled<br><br>";

echo "<strong style='color: red; font-size: 18px;'>⚠️ IMPORTANT: Delete this file now for security!</strong><br>";
echo "<code>rm create-storage-link.php</code><br>";
echo "<em>This file contains sensitive system information and should not remain on your server.</em>";
?>
