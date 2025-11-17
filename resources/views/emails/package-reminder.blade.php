@component('mail::message')
# Session Credits Reminder

Hello **{{ $clientName }}**,

We wanted to remind you that you still have **{{ $sessionsRemaining }} session{{ $sessionsRemaining > 1 ? 's' : '' }}** remaining for your **{{ $serviceName }}** package.

## Package Details

@component('mail::panel')
**Service:** {{ $serviceName }}
**Sessions Remaining:** {{ $sessionsRemaining }}
**Branch:** {{ $branchName }}
**Expiry Date:** {{ $expiryDate }}
@if($daysUntilExpiry > 0)
**Days Until Expiry:** {{ $daysUntilExpiry }} day{{ $daysUntilExpiry > 1 ? 's' : '' }}
@else
**Status:** ⚠️ Package has expired
@endif
@endcomponent

@if($daysUntilExpiry > 0 && $daysUntilExpiry <= 30)
@component('mail::panel')
⏰ **Expiring Soon!**
Your package will expire in {{ $daysUntilExpiry }} day{{ $daysUntilExpiry > 1 ? 's' : '' }}. Book your sessions now to make the most of your package!
@endcomponent
@endif

@if($sessionsRemaining > 0 && $daysUntilExpiry > 0)
Don't let your sessions go to waste! Book your next appointment today and continue your journey to healthier, more beautiful skin.

@component('mail::button', ['url' => config('app.url')])
Book Your Session Now
@endcomponent
@elseif($daysUntilExpiry <= 0)
Unfortunately, your package has expired. Please contact our staff if you'd like to purchase a new package.
@endif

---

If you have any questions or need assistance booking your sessions, please don't hesitate to contact our staff at **{{ $branchName }}**.

Thank you for choosing Skin911!

Best regards,
**The Skin911 Team**

@component('mail::subcopy')
This is an automated reminder about your remaining session credits. If you have already used all your sessions or have questions about this email, please contact us.
@endcomponent
@endcomponent
