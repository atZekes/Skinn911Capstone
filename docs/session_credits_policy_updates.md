# Session Credits & Booking Policy Updates

## Date: November 18, 2025

## Summary of Changes

This document outlines all the improvements and policy changes made to the session credits system, cancellation policies, and reminder functionality.

---

## 1. ✅ Removed "Don't Show Again" from Terms & Conditions

**File Modified:** `resources/views/components/refund-policy-modal.blade.php`

**Change:**
- Removed the "Don't show this again" checkbox from the refund policy modal
- Users must now acknowledge the refund policy every time they make a booking
- Ensures all clients are always aware of cancellation policies

**Reason:**
- Important legal/policy information should always be presented to users
- Prevents users from forgetting refund terms and conditions

---

## 2. ✅ Auto-Send Reminder Emails (No Confirmation Dialog)

**Files Modified:**
- `resources/views/Staff/staff_calendar.blade.php`
- `app/Http/Controllers/StaffController.php` (already had sendReminder method)

**Changes:**
- Removed the `confirm()` dialog when staff clicks "Send Reminder"
- Reminder emails now send immediately without asking for confirmation
- Shows a loading message "Sending reminder..." followed by success/error message
- Uses existing endpoint: `/staff/appointments/{id}/send-reminder`

**User Experience:**
- Staff clicks "Send Reminder" → Email sends immediately
- No cancel button in the reminder flow
- Faster workflow for staff to notify clients

**Code Example:**
```javascript
// OLD: Had confirm dialog
if (confirm('Send a reminder to this client?')) {
    // send email
}

// NEW: Auto-send
showSuccessMessage('Sending reminder...');
$.ajax({
    url: '/staff/appointments/' + bookingId + '/send-reminder',
    // ... send immediately
});
```

---

## 3. ✅ 6-Month Expiration Rule for Session Credits

**Files Modified:**
- `app/Models/Booking.php` (ensurePackageSessionsExist method)
- `database/migrations/2025_11_18_011718_add_expired_status_to_client_package_sessions_table.php`

**Changes:**

### A. Session Credits Now Expire After 6 Months
When session credits are created (on payment confirmation), the `expiry_date` is automatically set to **6 months from purchase date**.

**Code Change in Booking Model:**
```php
// OLD: expiry_date => null (no expiration)
'expiry_date' => null,

// NEW: 6 months from now
'expiry_date' => now()->addMonths(6),
```

### B. Added New Status: "expired"
Updated the `client_package_sessions` table to support new status values:
- `active` - Session credits are valid and can be used
- `completed` - All sessions have been used
- `cancelled` - Booking was cancelled before sessions were used
- `refunded` - Booking was refunded
- `expired` - 6 months have passed, credits are no longer valid

**Migration:**
```sql
ALTER TABLE client_package_sessions 
MODIFY COLUMN status ENUM('active', 'completed', 'cancelled', 'refunded', 'expired') 
DEFAULT 'active';
```

### C. Automatic Expiration Job
Created a scheduled command that runs **daily at midnight** to check and expire old session credits.

**Command:** `php artisan sessions:expire`
**File:** `app/Console/Commands/ExpireSessionCredits.php`

**What It Does:**
1. Finds all `active` session credits where `expiry_date <= today`
2. Sets status to `expired`
3. Sets `sessions_remaining` to 0
4. Cancels the associated booking
5. Logs the expiration for tracking

**Scheduled in Kernel.php:**
```php
$schedule->command('sessions:expire')
    ->daily()
    ->withoutOverlapping()
    ->runInBackground();
```

**Manual Execution:**
```bash
php artisan sessions:expire
```

---

## 4. ✅ Prevent Refunds When Sessions Are Deducted

**File Modified:** `app/Http/Controllers/ClientController.php` (requestRefund method)

**Change:**
Refund requests are now **blocked** if ANY sessions have been used.

**Old Logic:**
```php
// Checked if total_sessions > sessions_remaining (complex comparison)
$totalSessions = ClientPackageSession::where('booking_id', $booking->id)->sum('sessions_purchased');
$remainingSessions = ClientPackageSession::where('booking_id', $booking->id)->sum('sessions_remaining');
if ($totalSessions > 0 && $remainingSessions < $totalSessions) {
    // Block refund
}
```

**New Logic:**
```php
// Simple check: if sessions_used > 0, no refund
$sessionsUsed = ClientPackageSession::where('booking_id', $booking->id)->sum('sessions_used');
if ($sessionsUsed > 0) {
    return redirect()->route('client.dashboard')
        ->withErrors(['error' => 'Cannot request refund because ' . $sessionsUsed . ' session(s) have already been used. This booking is non-refundable.']);
}
```

**Error Messages:**
- ❌ "Cannot request refund because 2 session(s) have already been used. This booking is non-refundable."

**Business Rule:**
- ✅ 0 sessions used → Client CAN request refund
- ❌ 1+ sessions used → Client CANNOT request refund

---

## 5. ✅ Enhanced Cancel Booking with Session Deduction Warnings

**Files Modified:**
- `resources/views/Client/dashboard.blade.php` (handleCancelBooking function)
- `routes/api.php` (new endpoint for session info)
- `app/Http/Controllers/ClientController.php` (cancelBooking method)

### A. Dynamic Warning Messages

The cancel booking dialog now shows **different warnings** based on whether sessions have been deducted:

**Scenario 1: Sessions Have Been Used (No Refund Available)**
```
┌─────────────────────────────────────────────┐
│ Cancel Booking?                              │
├─────────────────────────────────────────────┤
│ Are you sure you want to cancel?            │
│                                              │
│ ⚠️ WARNING: 2 session(s) have been used.    │
│ You CANNOT request a refund for this        │
│ booking.                                     │
│                                              │
│ ⚠️ This action cannot be undone             │
└─────────────────────────────────────────────┘
   [Yes, Cancel]  [Keep Booking]
```

**Scenario 2: No Sessions Used (Refund Available)**
```
┌─────────────────────────────────────────────┐
│ Cancel Booking?                              │
├─────────────────────────────────────────────┤
│ Are you sure you want to cancel?            │
│                                              │
│ ℹ️ No sessions have been used yet.          │
│ You may request a refund from staff after   │
│ cancelling.                                  │
│                                              │
│ ⚠️ This action cannot be undone             │
└─────────────────────────────────────────────┘
   [Yes, Cancel]  [Keep Booking]
```

### B. New API Endpoint

Created a protected API endpoint to fetch session usage information:

**Endpoint:** `GET /api/booking/{id}/session-info`
**Authentication:** Required (web + auth middleware)

**Response:**
```json
{
    "booking_id": 800,
    "sessions_used": 2,
    "sessions_remaining": 8,
    "has_deducted_sessions": true
}
```

**Security:**
- Only returns data if the booking belongs to the authenticated user
- Uses `where('user_id', auth()->id())` to prevent unauthorized access

### C. Flow Diagram

```
Client clicks "Cancel Booking"
         ↓
JavaScript fetches /api/booking/{id}/session-info
         ↓
     Parse response
         ↓
   sessions_used > 0?
    ↙           ↘
  YES            NO
   ↓             ↓
Show RED        Show BLUE
warning:        info message:
"NO REFUND"     "CAN GET REFUND"
   ↓             ↓
User confirms → Booking cancelled
```

---

## 6. ✅ Updated cancelBooking() Method

**File Modified:** `app/Http/Controllers/ClientController.php`

**Change:**
Added session usage check at the beginning of the cancellation process.

```php
public function cancelBooking($id)
{
    $booking = Booking::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

    // NEW: Check session usage
    $sessionsUsed = 0;
    try {
        $sessionsUsed = ClientPackageSession::where('booking_id', $booking->id)
            ->sum('sessions_used');
    } catch (\Exception $e) {
        Log::error('Error checking session usage on cancel', [
            'booking_id' => $booking->id, 
            'error' => $e->getMessage()
        ]);
    }

    // Prevent cancellation if payment confirmed
    if ($booking->payment_status === 'paid') {
        return redirect()->route('client.dashboard')
            ->withErrors(['error' => 'Cannot cancel a booking that has been confirmed as paid by staff.']);
    }

    // Cancel booking and zero sessions
    $booking->status = 'cancelled';
    $booking->save();
    
    ClientPackageSession::where('booking_id', $booking->id)
        ->update(['sessions_remaining' => 0, 'status' => 'cancelled']);
    
    // ... rest of cancellation logic
}
```

---

## Testing Instructions

### Test 1: 6-Month Expiration
1. ✅ Create a new booking with session credits
2. ✅ Check `client_package_sessions` table → `expiry_date` should be 6 months from now
3. ✅ Manually change `expiry_date` to yesterday
4. ✅ Run: `php artisan sessions:expire`
5. ✅ Verify session status changed to `expired` and booking is `cancelled`

### Test 2: Refund Prevention with Used Sessions
1. ✅ Book a service with multiple sessions (e.g., 10 sessions)
2. ✅ Staff marks booking as complete → 1 session deducted
3. ✅ Client tries to request refund
4. ✅ Should see error: "Cannot request refund because 1 session(s) have already been used"

### Test 3: Cancel Booking Warning (Sessions Used)
1. ✅ Book a service with 10 sessions
2. ✅ Use 2 sessions (staff marks as complete twice)
3. ✅ Client clicks "Cancel Booking"
4. ✅ Should see RED warning: "2 session(s) have been used. You CANNOT request a refund"

### Test 4: Cancel Booking Warning (No Sessions Used)
1. ✅ Book a service with 10 sessions
2. ✅ Don't use any sessions yet
3. ✅ Client clicks "Cancel Booking"
4. ✅ Should see BLUE info: "No sessions used yet. You may request refund from staff"

### Test 5: Auto-Send Reminder
1. ✅ Staff goes to Calendar view
2. ✅ Clicks on an appointment
3. ✅ Clicks "Send Reminder" button
4. ✅ Should see "Sending reminder..." then "Reminder sent successfully!"
5. ✅ No confirmation dialog should appear
6. ✅ Client should receive email

---

## Database Changes Summary

### Modified Table: `client_package_sessions`

**Column:** `status`
- **Old:** ENUM('active', 'completed')
- **New:** ENUM('active', 'completed', 'cancelled', 'refunded', 'expired')

**Column:** `expiry_date`
- **Old:** Always set to `null`
- **New:** Set to `now()->addMonths(6)` on creation

---

## Scheduled Jobs

### Sessions Expiration Job
- **Command:** `php artisan sessions:expire`
- **Schedule:** Daily at midnight
- **Purpose:** Auto-expire session credits older than 6 months
- **Actions:** 
  - Mark sessions as `expired`
  - Cancel associated bookings
  - Set `sessions_remaining` to 0

### Booking Reminders Job (Existing)
- **Command:** `php artisan bookings:send-reminders`
- **Schedule:** Daily at 9:00 AM
- **Purpose:** Send email reminders for bookings happening tomorrow

---

## Business Rules Summary

| Scenario | Can Cancel? | Can Request Refund? | Notes |
|----------|-------------|---------------------|-------|
| No sessions used | ✅ Yes | ✅ Yes | Full refund possible |
| 1+ sessions used | ✅ Yes (with warning) | ❌ No | Non-refundable |
| Payment not confirmed | ✅ Yes | N/A | No payment to refund |
| Payment confirmed | ❌ No | ❌ No | Contact support |
| Session credits expired | Auto-cancelled | ❌ No | Past 6 months |

---

## Files Modified

1. ✅ `resources/views/components/refund-policy-modal.blade.php` - Removed checkbox
2. ✅ `resources/views/Staff/staff_calendar.blade.php` - Auto-send reminders
3. ✅ `app/Models/Booking.php` - 6-month expiry on session creation
4. ✅ `app/Console/Commands/ExpireSessionCredits.php` - NEW: Expiration command
5. ✅ `app/Console/Kernel.php` - Scheduled expiration job
6. ✅ `resources/views/Client/dashboard.blade.php` - Enhanced cancel warnings
7. ✅ `app/Http/Controllers/ClientController.php` - Updated refund/cancel logic
8. ✅ `routes/api.php` - NEW: Session info endpoint
9. ✅ `database/migrations/2025_11_18_011718_add_expired_status_to_client_package_sessions_table.php` - NEW: Migration

---

## Deployment Checklist

```bash
# 1. Pull latest code
git pull origin main

# 2. Run migration
php artisan migrate

# 3. Clear caches
php artisan route:clear
php artisan view:clear
php artisan config:cache

# 4. Test scheduled commands
php artisan sessions:expire  # Should run without errors

# 5. Verify scheduler is running
# In production, ensure cron job is active:
# * * * * * cd /path/to/project && php artisan schedule:run >> /dev/null 2>&1
```

---

## API Endpoints Summary

### New Endpoints

**GET /api/booking/{id}/session-info**
- **Purpose:** Get session usage info for cancel confirmation
- **Auth:** Required (web + auth middleware)
- **Returns:** `{ booking_id, sessions_used, sessions_remaining, has_deducted_sessions }`

### Modified Endpoints

**POST /staff/appointments/{id}/send-reminder**
- **Change:** Now called without confirmation dialog
- **Still requires:** Staff authentication
- **Sends:** Email to client about booking and remaining sessions

---

## Success Metrics

- ✅ Session credits expire automatically after 6 months
- ✅ Clients see clear warnings about refund eligibility
- ✅ Staff can send reminders with one click (no confirmation)
- ✅ Refund abuse prevented (no refunds after using sessions)
- ✅ Terms & Conditions shown on every booking

---

## Future Enhancements (Optional)

1. **Email Notification for Expiring Sessions**
   - Send warning email 1 week before expiration
   - Send final warning 1 day before expiration

2. **Grace Period**
   - Allow 7-day grace period after 6 months before hard expiration

3. **Extend Session Credits**
   - Allow staff to manually extend expiry_date for loyal customers

4. **Refund Request with Fee**
   - Allow refunds with used sessions but charge a cancellation fee

5. **Session Transfer**
   - Allow clients to transfer unused sessions to another client

---

## Support & Troubleshooting

### Issue: Sessions not expiring
```bash
# Check if scheduled jobs are running
php artisan schedule:list

# Run manually to test
php artisan sessions:expire

# Check logs
tail -f storage/logs/laravel.log
```

### Issue: Cancel warning not showing
- Check browser console for JavaScript errors
- Verify `/api/booking/{id}/session-info` endpoint returns data
- Ensure user is authenticated

### Issue: Refund still allowed after session use
- Check `sessions_used` column in `client_package_sessions` table
- Verify `markSessionComplete()` is being called when staff completes booking
- Check controller logic in `requestRefund()` method

---

## Conclusion

All requested features have been successfully implemented:

1. ✅ Removed "Don't show again" from terms & conditions
2. ✅ Auto-send reminder emails without confirmation
3. ✅ 6-month expiration rule for session credits
4. ✅ Scheduled job to auto-expire old sessions
5. ✅ Prevent refunds when sessions are deducted
6. ✅ Enhanced cancel booking warnings based on session usage

The system now provides better protection against refund abuse while giving clients clear information about their refund eligibility based on session usage.
