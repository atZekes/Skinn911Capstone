@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="https://laravel.com/img/notification-logo.png" class="logo" alt="Laravel Logo">
@elseif (trim($slot) === config('app.name'))
<img src="{{ asset('img/skinlogo.png') }}" class="logo" alt="Skin911 Logo" style="height: 75px; width: auto;">
@else
{!! $slot !!}
@endif
</a>
</td>
</tr>
