<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\StaffAvailabilityController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\NotificationController;

Route::get('/booking/slots', [ClientController::class, 'getFullSlots']);
Route::get('/staff/availability', [StaffAvailabilityController::class, 'getAvailability']);

// Staff booking management routes
Route::get('/staff/booking-details', [StaffAvailabilityController::class, 'getBookingDetails']);
Route::post('/staff/confirm-booking/{bookingId}', [StaffAvailabilityController::class, 'confirmBooking']);
Route::post('/staff/reject-booking/{bookingId}', [StaffAvailabilityController::class, 'rejectBooking']);

// Validate promo code (AJAX) - enable session/auth for web users
Route::middleware(['web','auth'])->group(function () {
	Route::get('/promo/validate', [ClientController::class, 'validatePromo'])->name('api.promo.validate');
	Route::get('/staff', [ClientController::class, 'getStaffForBranch'])->name('api.staff');
});

// Chat widget API routes
Route::get('/chat/categories', [ChatController::class, 'getCategories']);
Route::get('/chat/services/{category}', [ChatController::class, 'getServicesByCategory']);
Route::get('/chat/branch-hours', [ChatController::class, 'getBranchHours']);

// Notification API routes - use web middleware for session support
Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::post('/notifications', [NotificationController::class, 'store']);
    Route::patch('/notifications/{notification}/read', [NotificationController::class, 'markAsRead']);
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead']);
});

// Staff booking management routes
Route::get('/staff/booking-details', [StaffAvailabilityController::class, 'getBookingDetails']);
Route::post('/staff/confirm-booking/{bookingId}', [StaffAvailabilityController::class, 'confirmBooking']);
Route::post('/staff/reject-booking/{bookingId}', [StaffAvailabilityController::class, 'rejectBooking']);

// (promo validate route defined above with web/auth middleware)

// Chat widget API routes
Route::get('/chat/categories', [ChatController::class, 'getCategories']);
Route::get('/chat/services/{category}', [ChatController::class, 'getServicesByCategory']);
Route::get('/chat/branch-hours', [ChatController::class, 'getBranchHours']);

// Return services and minimal metadata for a branch (used by staff Add Walk-In modal)
Route::get('/branches/{id}/services', function($id) {
	$branch = \App\Models\Branch::with(['services'])->findOrFail($id);
	$list = $branch->services->map(function($s){
		return [
			'id' => $s->id,
			'name' => $s->name,
			'price' => $s->pivot->price ?? $s->price ?? null,
			'duration' => $s->pivot->duration ?? $s->duration ?? 1,
			'active' => isset($s->pivot->active) ? (bool)$s->pivot->active : (isset($s->active) ? (bool)$s->active : true)
		];
	})->values();

	return response()->json([
		'branch_id' => $branch->id,
		'time_slot' => $branch->time_slot,
		'break_start' => $branch->break_start,
		'break_end' => $branch->break_end,
		'slot_capacity' => $branch->slot_capacity ?? 5,
		'services' => $list,
	]);
});

// Get session info for a booking (used by cancel booking confirmation)
Route::middleware(['web', 'auth'])->get('/booking/{id}/session-info', function($id) {
	$booking = \App\Models\Booking::where('id', $id)->where('user_id', auth()->id())->firstOrFail();

	$sessionsUsed = \App\Models\ClientPackageSession::where('booking_id', $booking->id)
		->sum('sessions_used');

	$sessionsRemaining = \App\Models\ClientPackageSession::where('booking_id', $booking->id)
		->sum('sessions_remaining');

	return response()->json([
		'booking_id' => $booking->id,
		'sessions_used' => $sessionsUsed,
		'sessions_remaining' => $sessionsRemaining,
		'has_deducted_sessions' => $sessionsUsed > 0
	]);
});
