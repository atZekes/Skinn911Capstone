# Critical Session Credits Bug Fixes

## Date: November 18, 2025

## Critical Issues Fixed

### 1. ❌ **CRITICAL BUG: Wrong Session Credits Displayed**

**Problem:**
- Booking #800 (with 10 sessions) showed 8 sessions left (from Booking #799)
- Multiple bookings of the same service showed incorrect session counts
- Sessions from one booking were displayed on another booking

**Root Cause:**
Both the client dashboard and staff appointments view had **fallback logic** that queried sessions by:
- `user_id` + `branch_id` + `service_id`

Instead of querying by:
- **`booking_id`** (unique identifier)

**Code Issue - Client Dashboard:**
```php
// BAD CODE (REMOVED):
$sessionsLeft = ClientPackageSession::where('booking_id', $booking->id)->sum('sessions_remaining');
if (!$sessionsLeft && isset($booking->service_id)) {
    // This fallback picks up sessions from OTHER bookings!
    $sessionsLeft = ClientPackageSession::where('user_id', Auth::id())
        ->where('branch_id', $booking->branch_id)
        ->where('service_id', $booking->service_id)
        ->where('status', 'active')
        ->sum('sessions_remaining');
}
```

**Code Issue - Staff Controller:**
```php
// BAD CODE (REMOVED):
$credits = ClientPackageSession::where('user_id', $b->user_id)
    ->where('branch_id', $staffBranchId)
    ->where('service_id', $b->service_id)
    ->active()
    ->sum('sessions_remaining');
```

**Fix Applied:**
```php
// GOOD CODE (FIXED):
// Only query by booking_id - each booking's sessions are independent
$sessionsLeft = ClientPackageSession::where('booking_id', $booking->id)
    ->sum('sessions_remaining');
```

**Files Modified:**
- ✅ `resources/views/Client/dashboard.blade.php` - Line 680
- ✅ `app/Http/Controllers/StaffController.php` - Line 853

**Impact:**
- ✅ Each booking now shows ONLY its own sessions
- ✅ Multiple bookings of same service are tracked independently
- ✅ Booking #800 will now show its correct 10 sessions (once payment confirmed)

---

### 2. ⚠️ **Booking #800 Not Registered in client_package_sessions Table**

**Problem:**
Only booking #799 has session records, booking #800 doesn't exist in the table.

**Root Cause:**
Booking #800 has `payment_status = 'pending'`. Session records are **only created** when:
1. Booking is created with `payment_status = 'paid'`, OR
2. Existing booking's `payment_status` is changed to `'paid'`

**How Sessions Are Created:**
```php
// In Booking model - booted() method
protected static function booted()
{
    // On booking creation
    static::created(function ($booking) {
        if ($booking->payment_status === 'paid') {
            $booking->ensurePackageSessionsExist();
        }
    });

    // On payment confirmation
    static::updated(function ($booking) {
        if ($booking->wasChanged('payment_status') && $booking->payment_status === 'paid') {
            $booking->ensurePackageSessionsExist();
        }
    });
}
```

**Solution:**
Staff must click **"Confirm Payment"** button for Booking #800.

**Expected Result After Payment Confirmation:**
```sql
-- Booking #800 will have:
INSERT INTO client_package_sessions (
    booking_id,
    user_id,
    service_id,
    branch_id,
    total_sessions,
    sessions_remaining,
    sessions_used,
    status
) VALUES (
    800,                    -- booking_id
    54,                     -- user_id (Leo ezekiel Genodiala)
    [service_id],           -- Skin911 Complete Facial
    [branch_id],            -- Banilad Town Centre
    10,                     -- total_sessions
    10,                     -- sessions_remaining
    0,                      -- sessions_used
    'active'                -- status
);
```

**Action Required:**
1. Go to staff appointments table
2. Find Booking #800 (Payment Pending status)
3. Click **"Confirm Payment"** button
4. Session record will be auto-created
5. Client will see "10 left" badge

---

### 3. 🔄 **Book Next Session - Changed from Notification to Reschedule**

**Old Behavior (REMOVED):**
- Clicked "Book Next Session"
- Sent notification to all staff at branch
- Staff had to manually contact client
- Client couldn't see available time slots

**New Behavior (IMPLEMENTED):**
- Click "Book Next Session"
- SweetAlert confirmation appears
- **Opens the reschedule modal** (same as reschedule button)
- Client can **see available time slots**
- Client picks new date/time
- Booking is updated with new slot
- Staff sees updated appointment in calendar
- **No manual notification needed**

**Code Changes:**

**A. Controller Method Simplified:**
```php
// Old: Sent notifications to staff
// New: Just validates and returns booking data
public function bookNextSession($id)
{
    // Check sessions remaining
    // Check payment confirmed
    // Return booking details for reschedule modal
    return response()->json([
        'success' => true,
        'booking_id' => $booking->id,
        'sessions_remaining' => $remainingSessions,
        'message' => 'Please select a new time slot for your next session.'
    ]);
}
```

**B. Frontend - Opens Reschedule Modal:**
```javascript
// When "Book Next Session" clicked:
Swal.fire({
    title: 'Book Next Session',
    html: 'Select a new date and time for your next session...'
}).then(() => {
    // Open the existing reschedule modal
    $('#rescheduleModal' + bookingId).modal('show');
});
```

**User Experience:**
1. ✅ Client sees available slots immediately
2. ✅ Real-time availability checking
3. ✅ No waiting for staff to call back
4. ✅ Staff sees new appointment automatically
5. ✅ Booking remains tied to original booking_id
6. ✅ Session count unchanged (doesn't deduct until completed)

**Files Modified:**
- ✅ `app/Http/Controllers/ClientController.php` - `bookNextSession()` method
- ✅ `resources/views/Client/dashboard.blade.php` - JavaScript handler

---

## Testing Steps

### Test 1: Verify Session Credits Show Correctly
1. ✅ Have 2 bookings of "Skin911 Complete Facial" with different booking IDs
2. ✅ Booking #799: Confirm payment, complete 2 sessions → Should show "8 left"
3. ✅ Booking #800: Confirm payment → Should show "10 left" (NOT 8!)
4. ✅ Both bookings should show independent session counts

### Test 2: Confirm Payment Creates Sessions
1. ✅ Create new booking with multi-session service
2. ✅ Verify booking created with `payment_status = 'pending'`
3. ✅ Check `client_package_sessions` table → Should be empty for this booking
4. ✅ Staff clicks "Confirm Payment" button
5. ✅ Check `client_package_sessions` table → Should now have record with correct sessions
6. ✅ Client dashboard should show session badge

### Test 3: Book Next Session Works Like Reschedule
1. ✅ Have booking with sessions remaining
2. ✅ Click "Book Next Session" button in client dashboard
3. ✅ Confirm in SweetAlert modal
4. ✅ Reschedule modal should open
5. ✅ Select new available date/time slot
6. ✅ Submit reschedule
7. ✅ Verify booking date/time updated
8. ✅ Verify sessions_remaining unchanged
9. ✅ Verify staff sees updated appointment in calendar

---

## Database Query Reference

### ✅ CORRECT WAY - Query by booking_id
```php
// Each booking has its own session records
$sessions = ClientPackageSession::where('booking_id', $bookingId)
    ->sum('sessions_remaining');
```

### ❌ WRONG WAY - Query by service_id (REMOVED)
```php
// This picks up sessions from ALL bookings of the same service!
$sessions = ClientPackageSession::where('user_id', $userId)
    ->where('service_id', $serviceId)
    ->sum('sessions_remaining');
```

---

## Data Model Clarification

### `client_package_sessions` Table Structure
```
booking_id       → UNIQUE per booking (even if same service)
user_id          → Client who purchased
service_id       → Service booked
branch_id        → Branch where service is performed
total_sessions   → Total sessions purchased (e.g., 10)
sessions_used    → How many completed (e.g., 2)
sessions_remaining → How many left (e.g., 8)
status           → 'active', 'completed', 'cancelled', 'refunded'
```

### Example Data After Fixes:
```
| booking_id | user_id | service_id | total_sessions | sessions_remaining | sessions_used |
|------------|---------|------------|----------------|--------------------|--------------| 
| 799        | 54      | 1          | 10             | 8                  | 2            |
| 800        | 54      | 1          | 10             | 10                 | 0            |
```

**Key Point:** Same `user_id` and `service_id`, but **different `booking_id`** means **separate session tracking**!

---

## Summary

**3 Critical Fixes Applied:**

1. ✅ **Fixed session display bug** - Sessions now show per booking_id, not per service_id
2. ✅ **Clarified session creation** - Requires payment confirmation
3. ✅ **Improved Book Next Session** - Now works like reschedule with slot picker

**Files Modified:** 3
- `app/Http/Controllers/ClientController.php`
- `app/Http/Controllers/StaffController.php`
- `resources/views/Client/dashboard.blade.php`

**Breaking Changes:** None - backwards compatible

**Action Required:**
- Staff must confirm payment for Booking #800 to create its session records
- Clear browser cache and refresh pages to see fixes

---

## Production Deployment

```bash
# Clear caches
php artisan route:clear
php artisan view:clear
php artisan config:cache

# Restart queue workers if using
php artisan queue:restart
```

No database migrations needed - all fixes are code-level only.
