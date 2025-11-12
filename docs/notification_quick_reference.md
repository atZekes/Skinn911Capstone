# Booking Notification Quick Reference

## How It Works

When staff performs any of these actions on a client's booking:
1. **Cancel** → Client gets "Booking Cancelled" notification (warning)
2. **Complete** → Client gets "Booking Completed" notification (success)
3. **Send Reminder** → Client gets "Appointment Reminder" notification (info)
4. **Refund** → Client gets "Refund Processed" notification (info)

Each notification is:
- ✅ Saved to database (persists across page refreshes)
- ✅ Sent in real-time via Pusher (instant delivery)
- ✅ Linked to booking via `booking_id` (clickable)
- ✅ Marked as unread initially
- ✅ Can be marked as read by client

## Testing Instructions

### 1. Create Test Notifications
Run the test script to create sample notifications:
```bash
php test_booking_notifications.php
```

This will create 4 test notifications for a client user with an existing booking.

### 2. View Notifications in Database
Check notifications in database:
```bash
php artisan tinker --execute="print_r(\App\Models\Notification::latest()->take(5)->get()->toArray());"
```

### 3. Test in Browser
1. Login as a client user
2. Check notification bell icon in header
3. Click on notification to view details
4. If notification has `booking_id`, clicking redirects to dashboard
5. Refresh the page - notifications should persist

### 4. Test Real-World Scenarios

#### Test Cancellation Notification
1. Login as staff
2. Go to Appointments page
3. Cancel a client's appointment
4. Client should receive notification immediately
5. Notification should persist after page refresh

#### Test Completion Notification
1. Login as staff
2. Go to Appointments page
3. Mark an appointment as completed
4. Client receives "Booking Completed" notification

#### Test Reminder Notification
1. Login as staff
2. Go to Appointments page
3. Click "Send Reminder" on an upcoming appointment
4. Client receives reminder notification

#### Test Refund Notification
1. Login as staff
2. Go to Appointments page
3. Process refund for a booking
4. Client receives "Refund Processed" notification

### 5. Test API Endpoints

#### Get all notifications (as authenticated client):
```bash
curl -X GET http://localhost:8000/api/notifications \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Accept: application/json"
```

#### Mark notification as read:
```bash
curl -X PATCH http://localhost:8000/api/notifications/1/read \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Accept: application/json"
```

#### Mark all as read:
```bash
curl -X POST http://localhost:8000/api/notifications/mark-all-read \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Accept: application/json"
```

## Notification Structure in Database

| Field | Type | Description |
|-------|------|-------------|
| id | int | Primary key |
| user_id | int | Client who receives notification |
| title | string | e.g., "Booking Cancelled" |
| message | text | Detailed message |
| type | enum | success, error, warning, info |
| read | boolean | false by default |
| booking_id | int | Nullable, links to bookings table |
| data | json | Additional data |
| created_at | timestamp | When notification was created |
| updated_at | timestamp | When notification was last updated |

## Notification Types

| Type | Color | Used For |
|------|-------|----------|
| success | Green | Completions, confirmations |
| warning | Yellow/Orange | Cancellations |
| info | Blue | Reminders, refunds, general info |
| error | Red | Errors, failures |

## Client-Side JavaScript Integration

The client-side notification system in `clientapp.blade.php` handles:
- Loading notifications on page load
- Receiving real-time notifications via Pusher
- Displaying notification badge count
- Marking notifications as read
- Redirecting to dashboard when clicking booking-related notifications

## Troubleshooting

### Notifications not appearing
1. Check database: `SELECT * FROM notifications WHERE user_id = X;`
2. Check Pusher credentials in `.env`
3. Check browser console for JavaScript errors
4. Verify user is authenticated

### Notifications not persisting
1. Verify `sendPushNotification()` is being called
2. Check `app/Models/Notification.php` fillable fields
3. Verify database table structure matches model
4. Check Laravel logs: `storage/logs/laravel.log`

### Real-time not working
1. Check Pusher app credentials in `.env`
2. Verify Pusher script is loaded in blade template
3. Check browser console for Pusher connection errors
4. Test Pusher connection: https://dashboard.pusher.com/apps/YOUR_APP_ID/debug_console

## Related Files
- Model: `app/Models/Notification.php`
- API Controller: `app/Http/Controllers/NotificationController.php`
- Staff Controller: `app/Http/Controllers/StaffController.php`
- Client Controller: `app/Http/Controllers/ClientController.php`
- Reminder Command: `app/Console/Commands/SendBookingReminders.php`
- Client Layout: `resources/views/client/layouts/clientapp.blade.php`
- Migration: `database/migrations/2025_11_12_155056_create_notifications_table.php`
- Test Script: `test_booking_notifications.php`
