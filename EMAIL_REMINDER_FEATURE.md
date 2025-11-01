# Email Reminder Feature Documentation

## Overview
This feature allows staff members to send email reminders to clients about their upcoming appointments directly from the staff appointments management page.

## Feature Components

### 1. User Interface
**Location:** `resources/views/Staff/staff_appointments.blade.php` (Lines ~106-110)

**Button Implementation:**
```blade
<form action="{{ route('staff.sendReminder', $appointment->id) }}" method="POST" style="display:inline-block;" class="send-reminder-form">
  @csrf
  <button type="submit" class="mb-1 btn btn-info btn-sm" title="Send reminder email to client">
    <i class="fa fa-envelope"></i> Send Reminder
  </button>
</form>
```

**Features:**
- Info-colored button with envelope icon
- Inline form submission
- Custom CSS class for JavaScript handling
- Tooltip showing button purpose
- Located in actions column alongside Reschedule and Cancel buttons

### 2. Routing
**Location:** `routes/web.php` (Line ~116)

```php
Route::post('/staff/appointments/{id}/send-reminder', [App\Http\Controllers\StaffController::class, 'sendReminder'])
    ->name('staff.sendReminder');
```

**Route Details:**
- Method: POST
- URL: `/staff/appointments/{id}/send-reminder`
- Controller: StaffController@sendReminder
- Name: staff.sendReminder
- Middleware: staff authentication (inherited from group)

### 3. Controller Method
**Location:** `app/Http/Controllers/StaffController.php` (Lines ~790-810)

```php
public function sendReminder($id)
{
    try {
        // Find the booking with relationships
        $booking = \App\Models\Booking::with(['user', 'branch', 'service', 'package'])->findOrFail($id);
        
        // Validate that booking has a user with email
        if (!$booking->user || !$booking->user->email) {
            return redirect()->route('staff.appointments')
                ->with('error', 'Cannot send reminder: No email address found for this booking.');
        }
        
        // Send the reminder email
        Mail::to($booking->user->email)->send(new BookingReminder($booking));
        
        return redirect()->route('staff.appointments')
            ->with('success', 'Reminder email sent successfully to ' . $booking->user->email);
    } catch (\Exception $e) {
        Log::error('Failed to send booking reminder: ' . $e->getMessage());
        return redirect()->route('staff.appointments')
            ->with('error', 'Failed to send reminder email. Please try again.');
    }
}
```

**Process Flow:**
1. Receives booking ID from route parameter
2. Loads booking with eager-loaded relationships (user, branch, service, package)
3. Validates that user exists and has an email address
4. Sends email using BookingReminder mailable
5. Returns success message with recipient email
6. Catches and logs any exceptions
7. Returns error message if sending fails

### 4. Mailable Class
**Location:** `app/Mail/BookingReminder.php`

```php
<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Booking;

class BookingReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reminder: Upcoming Appointment at Skin911',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.booking-reminder',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
```

**Key Features:**
- Uses queue system for async sending
- Serializes booking model for queue storage
- Professional subject line
- Uses dedicated view template
- No attachments

### 5. Email Template
**Location:** `resources/views/emails/booking-reminder.blade.php`

**Template Features:**
- Professional gradient header (pink gradient matching brand)
- Responsive design (max-width: 600px)
- Clear reminder notice with icon
- Comprehensive booking details section:
  - Booking ID (highlighted)
  - Branch name
  - Service/Package name
  - Date (formatted as "Monday, January 1, 2024")
  - Time slot (highlighted)
  - Payment method
- Branch contact information box:
  - Address with icon
  - Contact number with icon
  - Operating days with icon
  - Operating hours with icon
- Important reminders list:
  - Arrive 10 minutes early
  - Bring valid ID
  - 24-hour cancellation policy
  - Payment-specific reminders (pending/cash)
- Professional footer:
  - Contact email and phone
  - Social media links (Facebook, Instagram)
  - Copyright notice
  - Auto-email disclaimer

**Design Highlights:**
- Consistent branding colors (#F56289, #FF8FAB)
- Clean box-shadow styling
- Colored icons for visual clarity
- Yellow reminder box for attention
- Light blue contact info box
- Mobile-responsive layout

### 6. JavaScript Enhancement
**Location:** `resources/views/Staff/staff_appointments.blade.php` (Lines ~1530-1540)

```javascript
// Specific handler for send reminder forms with custom loading message
const reminderForms = document.querySelectorAll('.send-reminder-form');
reminderForms.forEach(function(form) {
    form.addEventListener('submit', function(e) {
        const submitBtn = form.querySelector('button[type="submit"]');
        if (submitBtn && !submitBtn.disabled) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Sending...';
        }
    });
});
```

**Functionality:**
- Prevents double-submission
- Shows loading spinner
- Changes button text to "Sending..."
- Provides visual feedback
- Works with existing double-submit prevention system

## User Experience Flow

### Happy Path
1. Staff member views appointments list
2. Clicks "Send Reminder" button for specific appointment
3. Button shows loading state ("Sending...")
4. Email is sent to client's registered email
5. Page refreshes with success message: "Reminder email sent successfully to [email]"
6. Client receives professional reminder email

### Error Scenarios

#### No Email Address
- **Trigger:** Booking has no associated user or user has no email
- **Response:** Error message "Cannot send reminder: No email address found for this booking."
- **Resolution:** Staff should contact client via phone

#### Email Sending Failure
- **Trigger:** SMTP error, network issue, invalid email format
- **Response:** Error message "Failed to send reminder email. Please try again."
- **Logging:** Error logged to Laravel logs with details
- **Resolution:** Staff can retry or check email configuration

#### Booking Not Found
- **Trigger:** Invalid booking ID in URL
- **Response:** 404 error page
- **Resolution:** Return to appointments list

## Email Configuration Requirements

### SMTP Settings (.env)
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=skin911capstone@gmail.com
MAIL_PASSWORD=dgymutslhgfrgram
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=skin911capstone@gmail.com
MAIL_FROM_NAME="Skin911"
```

### Configuration Files
- `config/mail.php` - Mail driver settings
- `config/services.php` - Service provider configs
- Gmail App Password required (not regular password)

## Testing Checklist

### Functional Tests
- [ ] Click "Send Reminder" button on valid appointment
- [ ] Verify success message appears
- [ ] Check client receives email at correct address
- [ ] Verify email contains correct booking details
- [ ] Test with service-only booking
- [ ] Test with package-only booking
- [ ] Test with both service and package
- [ ] Test with different payment methods

### Edge Cases
- [ ] Booking with no user (should show error)
- [ ] User with no email (should show error)
- [ ] Invalid booking ID (should 404)
- [ ] Network timeout (should show error)
- [ ] Invalid email format (should show error)
- [ ] Cancelled appointment (should send but note status)

### UI/UX Tests
- [ ] Button shows loading state immediately
- [ ] Cannot double-click button
- [ ] Success message is visible and clear
- [ ] Error message is visible and clear
- [ ] Page doesn't freeze during send
- [ ] Works alongside other action buttons

### Email Content Tests
- [ ] Subject line correct
- [ ] Sender name/email correct
- [ ] Booking ID matches
- [ ] Date formatted correctly
- [ ] Time slot displayed
- [ ] Branch info correct
- [ ] Service/package names correct
- [ ] Contact info accurate
- [ ] Links functional
- [ ] Mobile responsive display

## Maintenance Notes

### Dependencies
- Laravel Mail facade
- Gmail SMTP service
- Booking model relationships (user, branch, service, package)
- Bootstrap 5 (for spinner and button styles)
- Font Awesome (for envelope icon)

### Log Monitoring
Check `storage/logs/laravel.log` for:
- Failed email sends
- Missing relationships
- SMTP connection errors
- Queue failures (if queue driver enabled)

### Future Enhancements
1. **Batch Reminders**: Send reminders to all appointments for tomorrow
2. **Scheduled Reminders**: Auto-send 24h before appointment
3. **SMS Integration**: Add SMS reminder option
4. **Template Customization**: Allow staff to edit reminder message
5. **Send History**: Track which reminders were sent and when
6. **Resend Prevention**: Block sending duplicate reminders within timeframe
7. **Read Receipts**: Track if client opened the email
8. **Calendar Attachment**: Include .ics file for calendar import

## Security Considerations

### Access Control
- Route protected by staff middleware
- Staff can only send reminders for appointments in their branch
- No direct email manipulation by staff

### Data Protection
- Email addresses not exposed in UI
- Booking details only sent to registered user email
- No sensitive payment info in email
- All data transmission via encrypted SMTP (TLS)

### Rate Limiting
- Consider adding rate limit to prevent abuse
- Suggested: 10 reminders per minute per staff member

## Integration Points

### Models Used
- `App\Models\Booking` - Main booking data
- `App\Models\User` - Client information
- `App\Models\Branch` - Branch details
- `App\Models\Service` - Service information
- `App\Models\Package` - Package information

### Facades Used
- `Mail` - Email sending
- `Log` - Error logging

### Views
- `resources/views/Staff/staff_appointments.blade.php` - UI button
- `resources/views/emails/booking-reminder.blade.php` - Email template
- `resources/views/layouts/staffapp.blade.php` - Success/error messages

### Routes
- `staff.appointments` - Return route after sending
- `staff.sendReminder` - Reminder action route

## Troubleshooting Guide

### Email Not Sending
1. Check .env MAIL_* settings
2. Verify Gmail app password is correct
3. Check Laravel logs for errors
4. Test with `php artisan tinker` and `Mail::raw()`
5. Verify port 587 not blocked by firewall

### Wrong Email Content
1. Clear view cache: `php artisan view:clear`
2. Check booking relationships loaded
3. Verify template variables exist
4. Test with dd($booking) in controller

### Button Not Working
1. Check browser console for JS errors
2. Verify CSRF token present in form
3. Check route registered: `php artisan route:list | grep sendReminder`
4. Verify staff authentication working

### Success Message Not Showing
1. Check layout file has session flash display
2. Verify redirect goes to correct route
3. Clear session cache
4. Check session driver in .env

## Version History

### v1.0.0 (Current)
- Initial implementation
- Basic email reminder functionality
- Professional email template
- Loading state feedback
- Error handling and logging

---

**Last Updated:** January 2025  
**Maintained By:** Development Team  
**Related Docs:** 
- `CHAT_IMPLEMENTATION_PROGRESS.md`
- `PAYMENT_MODAL_INSTRUCTIONS.md`
- `PROMO_BRANCH_RESTRICTION.md`
