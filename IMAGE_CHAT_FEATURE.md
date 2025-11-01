# Image Attachment Feature in Chat System

## Overview
The chat system now fully supports image attachments, allowing clients to send images to specific branches and staff members to view and respond with images.

## Implementation Summary

### 1. Database Changes ✅
- **Migration Created**: `2025_11_01_001808_add_image_to_chat_messages_table.php`
- **Column Added**: `image` (nullable string) in `chat_messages` table
- **Purpose**: Stores the path to uploaded images in the `storage/app/public/chat_images/` directory

### 2. Model Updates ✅
**File**: `app/Models/ChatMessage.php`
- Added `'image'` to the `$fillable` array
- Model now accepts image data when creating/updating chat messages

### 3. Client-Side Features ✅

#### Chat Widget (Client Interface)
**Files Modified**:
- `public/js/client/chat-widget.js`
- `public/css/client/chat-widget.css`
- `resources/views/layouts/clientapp.blade.php`

**Features**:
- **📎 Attach Button**: Paperclip icon button to select images
- **🖼️ Image Preview**: Shows selected image before sending
- **❌ Remove Preview**: Cancel button to remove selected image
- **📤 Send Images**: Can send images with or without text
- **🔍 View Images**: Click images to open full-size in new tab
- **📊 File Validation**: 
  - Max size: 5MB
  - Accepted formats: JPEG, PNG, JPG, GIF

#### How It Works (Client):
1. Client clicks on the chat widget button
2. Selects "Talk to Staff" and chooses a branch
3. Clicks the paperclip icon to attach an image
4. Image preview appears with option to remove
5. Types optional message and clicks Send
6. Image is uploaded and displayed in chat

### 4. Staff-Side Features ✅

#### Staff Interact Page
**File**: `resources/views/Staff/staffinteract.blade.php`

**Features**:
- **📎 Attach Button**: Staff can attach images in replies
- **🖼️ Image Preview**: Preview before sending
- **👀 View Client Images**: All client images are displayed in chat
- **🔍 Clickable Images**: Click to view full-size
- **📊 Same Validation**: 5MB max, image formats only

#### Staff Controller
**File**: `app/Http/Controllers/StaffController.php`
- `sendReply()` method handles image uploads
- Images stored in `storage/app/public/chat_images/`
- Images are branch-specific (staff only see messages from their branch)

### 5. Backend API ✅

#### ChatMessageController
**File**: `app/Http/Controllers/ChatMessageController.php`

**Endpoints Updated**:
- `POST /api/chat/send` - Now accepts both text and images
  - Accepts `FormData` for file uploads
  - Validates image type and size
  - Stores images in public storage
  - Returns image path in response

- `GET /api/chat/messages` - Returns messages with image paths
  - Images accessible via `/storage/chat_images/{filename}`

### 6. Real-Time Features ✅
**Integration with Pusher**:
- Images are broadcast in real-time via Pusher
- Staff receive notifications when clients send images
- Clients receive images from staff instantly
- Fallback polling system for reliability

### 7. Security & Validation ✅
**Validation Rules**:
```php
'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120' // Max 5MB
```

**Security Measures**:
- CSRF token required for all uploads
- File type validation on server-side
- File size limits enforced
- Images stored outside web root with symlink
- Authenticated users only can upload

## File Structure

```
storage/
├── app/
│   └── public/
│       └── chat_images/          # Uploaded chat images
│           ├── {timestamp}_{unique_id}.jpg
│           └── ...
```

```
public/
└── storage/                      # Symlink to storage/app/public
    └── chat_images/              # Accessible chat images
```

## How to Use

### For Clients:
1. Open the chat widget (bottom-right corner)
2. Click "Talk to Staff" and select a branch
3. Click the **📎 paperclip icon** next to the message input
4. Select an image from your device
5. Preview appears - click **×** to remove if needed
6. Type an optional message
7. Click **Send** to submit

### For Staff:
1. Go to the "Interact" tab in staff dashboard
2. Select a customer from the list
3. View all messages including images
4. Click **📎 paperclip icon** to attach an image in your reply
5. Preview appears - click **×** to remove if needed
6. Type an optional message
7. Click **Send** to submit

## Branch-Specific Chat

**Important**: Chat messages are branch-specific!
- Clients select which branch to chat with
- Staff only see messages sent to their assigned branch
- Each staff member can only respond to their branch's customers
- Images are organized by branch context

## Testing Checklist

- [x] Database migration successful
- [x] Client can attach images
- [x] Client can preview images before sending
- [x] Client can send image-only messages
- [x] Client can send text + image messages
- [x] Staff can view client images
- [x] Staff can attach images in replies
- [x] Images display correctly in chat history
- [x] Images are clickable to view full-size
- [x] File size validation works (5MB limit)
- [x] File type validation works (images only)
- [x] Real-time updates with Pusher
- [x] Branch-specific filtering works

## Technical Details

### Image Upload Process:
1. Client selects image via file input
2. Image is validated on frontend (size/type)
3. FormData object created with image + message
4. AJAX POST to `/api/chat/send` with CSRF token
5. Backend validates image (Laravel validation)
6. Image stored with unique filename: `{timestamp}_{uniqid}.{ext}`
7. Path saved to `chat_messages.image` column
8. Message broadcasted via Pusher
9. Image accessible at `/storage/chat_images/{filename}`

### Database Schema:
```sql
ALTER TABLE `chat_messages` 
ADD COLUMN `image` VARCHAR(255) NULL AFTER `message`;
```

### Storage Configuration:
- **Disk**: `public` (configured in `config/filesystems.php`)
- **Path**: `storage/app/public/chat_images/`
- **Access**: Via symlink at `public/storage/`
- **URL**: `https://yourdomain.com/storage/chat_images/{filename}`

## Troubleshooting

### Issue: Images not displaying
**Solution**: Ensure storage link exists
```bash
php artisan storage:link
```

### Issue: Upload fails with 413 error
**Solution**: Increase upload limits in php.ini
```ini
upload_max_filesize = 10M
post_max_size = 10M
```

### Issue: Permission denied errors
**Solution**: Check storage permissions
```bash
chmod -R 775 storage/
chmod -R 775 public/storage/
```

### Issue: Images not showing for staff
**Solution**: Check branch_id matching
- Ensure staff has `branch_id` set
- Verify messages have correct `branch_id`
- Check staff authentication guard

## Future Enhancements (Optional)

Possible improvements:
- [ ] Image compression before upload
- [ ] Multiple image uploads per message
- [ ] Image gallery view
- [ ] Download all images from conversation
- [ ] Image thumbnails for performance
- [ ] Video/file attachments support
- [ ] Emoji reactions on images
- [ ] Image annotations/markup

## Maintenance

**Regular Tasks**:
- Monitor `storage/app/public/chat_images/` folder size
- Implement cleanup policy for old images (optional)
- Backup chat images with database backups

**Storage Cleanup Script** (Optional):
```php
// Delete images older than 90 days
$oldDate = now()->subDays(90);
ChatMessage::where('created_at', '<', $oldDate)
    ->whereNotNull('image')
    ->each(function($message) {
        Storage::disk('public')->delete($message->image);
        $message->update(['image' => null]);
    });
```

## Conclusion

✅ **Feature Complete!**

The image attachment feature is now fully functional for both clients and staff. Clients can attach images when chatting with specific branches, and staff can view those images and respond with their own images. All images are branch-specific, properly validated, and integrated with the real-time chat system.

**Created**: November 1, 2025
**Status**: Production Ready ✅
