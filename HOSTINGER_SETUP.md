# Hostinger Deployment Checklist for Chat Images

## Your Current Setup
Your .htaccess redirects everything to /public/ directory, which is CORRECT for Hostinger.

## Steps to Fix Image Display on Hostinger:

### 1. Update .env File on Hostinger
Make sure your .env file has:
```
APP_URL=https://yourdomain.com
```
(Replace with your actual domain)

### 2. Run create-storage-link.php
- Upload `create-storage-link.php` to your root directory
- Access it via browser: https://yourdomain.com/create-storage-link.php
- Follow the instructions on screen
- **DELETE the file after** for security!

### 3. Upload .htaccess for Storage
Upload the `.htaccess` file to: `storage/app/public/.htaccess`

### 4. Verify Setup
After running the script, test one of these URLs:
- https://yourdomain.com/storage/chat_images/
- https://yourdomain.com/public/storage/chat_images/

One should work (might show empty or access denied, but NOT 403 Forbidden)

### 5. Test Chat Images
Send a test image from client to staff and vice versa.

## File Structure on Hostinger
```
yourdomain.com/
├── .htaccess (your existing one with /public/ redirect)
├── public/
│   └── storage/ (symbolic link to ../../storage/app/public)
├── storage/
│   └── app/
│       └── public/
│           ├── .htaccess (new file we created)
│           └── chat_images/ (your uploaded images)
```

## Troubleshooting

### If images still show 403:
1. Check file permissions via Hostinger File Manager:
   - storage/app/public: 755
   - storage/app/public/chat_images: 755
   - Image files: 644

2. Contact Hostinger support and ask them to run:
   ```bash
   php artisan storage:link
   chmod -R 755 storage/app/public
   ```

3. Make sure the symbolic link exists:
   - Go to public/storage in File Manager
   - It should show as a link (arrow icon) pointing to ../../storage/app/public

### If images still don't load:
Check browser console for the actual URL being used. The URL should be:
- https://yourdomain.com/storage/chat_images/filename.jpg

NOT:
- https://yourdomain.com/public/storage/chat_images/filename.jpg (unless your .htaccess is different)

The `asset()` helper automatically handles the /public/ redirect based on your .htaccess.
