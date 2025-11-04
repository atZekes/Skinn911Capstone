# Chat Image Support

## Supported Image Formats

The chat system now supports the following image formats:

### Common Formats
- **JPEG** (.jpg, .jpeg) - Most common photo format
- **PNG** (.png) - Supports transparency
- **GIF** (.gif) - Animated images supported
- **WebP** (.webp) - Modern efficient format

### Additional Formats
- **BMP** (.bmp) - Bitmap images
- **SVG** (.svg) - Vector graphics
- **HEIC/HEIF** (.heic, .heif) - Apple's high-efficiency format

## File Size Limit
- Maximum file size: **10 MB**
- Previous limit: 5 MB

## Features
✅ Send images WITHOUT text message (image-only messages)
✅ Send images WITH text message
✅ Real-time image preview before sending
✅ Support for both client-to-staff and staff-to-client communication

## Usage

### For Clients:
1. Click the attachment icon 📎 in the chat widget
2. Select any supported image format
3. Preview appears - you can optionally add text
4. Click Send (works with or without text message)

### For Staff:
1. Select a customer from the list
2. Click the attachment icon 📎
3. Choose an image file
4. Preview appears - you can optionally add text
5. Click Send Reply (works with or without text message)

## Technical Details
- Backend validation: Laravel controller validates file type and size
- Frontend validation: JavaScript checks file type before upload
- Image storage: `storage/app/public/chat_images/`
- Public access: `/storage/chat_images/` (via .htaccess rewrite on Hostinger)

## Browser Compatibility
All modern browsers support these formats except:
- **HEIC/HEIF**: Limited browser support (iOS/Safari native, others may need conversion)
- **SVG**: Fully supported in all modern browsers
- **WebP**: Supported in Chrome, Edge, Firefox, Safari 14+
