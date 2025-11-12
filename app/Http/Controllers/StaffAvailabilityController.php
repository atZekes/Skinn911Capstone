<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Pusher\Pusher;

class StaffAvailabilityController extends Controller
{
    public function getAvailability(Request $request)
    {
        // Fetch all active bookings
        $bookings = Booking::where('status', 'active')->with('user')->get();
        $events = [];
        foreach ($bookings as $booking) {
            // Convert time_slot to start/end times
            $times = explode('-', $booking->time_slot);
            $start = $booking->date . 'T' . (isset($times[0]) ? trim($times[0]) : '09:00') . ':00';
            $end = $booking->date . 'T' . (isset($times[1]) ? trim($times[1]) : '10:00') . ':00';
            $events[] = [
                'title' => $booking->user ? $booking->user->name : 'Booked',
                'start' => $start,
                'end' => $end,
            ];
        }
        return response()->json($events);
    }

    /**
     * Get detailed booking information for a specific date and time slot
     */
    public function getBookingDetails(Request $request)
    {
        try {
            $date = $request->get('date');
            $slot = $request->get('slot');
            $branchId = $request->get('branch_id');

            // Parse the clicked slot time
            [$clickedStart, $clickedEnd] = explode('-', $slot, 2);
            $clickedStartTime = \Carbon\Carbon::createFromFormat('H:i', trim($clickedStart));

            // Get all bookings for this date that could occupy this slot
            $query = Booking::with(['user', 'service', 'package.services'])
                ->where('date', $date)
                ->where('status', '!=', 'cancelled');

            if ($branchId) {
                $query->where('branch_id', $branchId);
            }

            $allBookings = $query->get();

            // Filter bookings that occupy the clicked slot
            $occupyingBookings = $allBookings->filter(function ($booking) use ($clickedStartTime, $branchId) {
                // Get service duration
                $duration = 1;
                if ($booking->service) {
                    $duration = $booking->service->duration ?? 1;
                    // Check for branch-specific duration override
                    $branchSpecific = $booking->service->branches()
                        ->where('branch_id', $branchId)
                        ->first();
                    if ($branchSpecific && $branchSpecific->pivot && $branchSpecific->pivot->duration) {
                        $duration = $branchSpecific->pivot->duration;
                    }
                } elseif ($booking->package) {
                    $duration = 0;
                    foreach ($booking->package->services as $service) {
                        $serviceDuration = $service->duration ?? 1;
                        // Check for branch-specific duration
                        $branchSpecific = $service->branches()
                            ->where('branch_id', $branchId)
                            ->first();
                        if ($branchSpecific && $branchSpecific->pivot && $branchSpecific->pivot->duration) {
                            $serviceDuration = $branchSpecific->pivot->duration;
                        }
                        $duration += $serviceDuration;
                    }
                    if ($duration <= 0) $duration = 1;
                }

                // Parse booking start time
                try {
                    [$bookingStart, $bookingEnd] = explode('-', $booking->time_slot, 2);
                    $bookingStartTime = \Carbon\Carbon::createFromFormat('H:i', trim($bookingStart));

                    // Check if the clicked slot falls within this booking's duration
                    for ($hour = 0; $hour < $duration; $hour++) {
                        $occupiedSlotStart = $bookingStartTime->copy()->addHours($hour);
                        if ($occupiedSlotStart->equalTo($clickedStartTime)) {
                            // Log for debugging
                            \Log::info("Booking {$booking->id} occupies clicked slot", [
                                'booking_id' => $booking->id,
                                'booking_start' => $booking->time_slot,
                                'duration' => $duration,
                                'clicked_slot' => $clickedStartTime->format('H:i'),
                                'occupied_slot' => $occupiedSlotStart->format('H:i'),
                                'hour_offset' => $hour
                            ]);
                            return true;
                        }
                    }
                } catch (\Exception $e) {
                    \Log::error("Error parsing booking time slot: " . $e->getMessage(), [
                        'booking_id' => $booking->id,
                        'time_slot' => $booking->time_slot
                    ]);
                    return false;
                }

                return false;
            });

            // Log the results for debugging
            \Log::info("Booking details query results", [
                'clicked_slot' => $slot,
                'date' => $date,
                'total_bookings_found' => $allBookings->count(),
                'occupying_bookings_found' => $occupyingBookings->count(),
                'occupying_booking_ids' => $occupyingBookings->pluck('id')->toArray()
            ]);

            // Format booking data with contact information
            $formattedBookings = $occupyingBookings->map(function ($booking) {
                $customerName = 'Walk-in Customer';
                $phone = 'Not provided';
                $email = 'Not provided';

                if ($booking->user) {
                    $customerName = $booking->user->name;
                    $phone = $booking->user->mobile_phone ?? 'Not provided';
                    $email = $booking->user->email ?? 'Not provided';
                } elseif ($booking->walkin_name) {
                    $customerName = $booking->walkin_name . ' (Walk-in)';
                    // For walk-ins, check if there are separate fields, otherwise use 'Not provided'
                    $phone = $booking->walkin_phone ?? 'Not provided';
                    $email = $booking->walkin_email ?? 'Not provided';
                }

                // Get service information
                $serviceName = 'Unknown Service';
                $packageServices = null;
                $price = null;

                if ($booking->package) {
                    $serviceName = $booking->package->name;
                    $packageServices = $booking->package->services->pluck('name')->implode(', ');
                    $price = $booking->package->price;
                } elseif ($booking->service) {
                    $serviceName = $booking->service->name;
                    $price = $booking->service->price;
                }

                return [
                    'id' => $booking->id,
                    'customer_name' => $customerName,
                    'phone' => $phone,
                    'email' => $email,
                    'service_name' => $serviceName,
                    'package_services' => $packageServices,
                    'price' => $price,
                    'status' => $booking->status ?? 'pending',
                    'created_at' => $booking->created_at->format('M j, Y g:i A')
                ];
            });

            return response()->json($formattedBookings);

        } catch (\Exception $e) {
            Log::error('Error getting booking details: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to load booking details'], 500);
        }
    }

    /**
     * Confirm a booking
     */
    public function confirmBooking(Request $request, $bookingId)
    {
        try {
            $booking = Booking::findOrFail($bookingId);

            // Update booking status to confirmed/active
            $booking->status = 'active';
            $booking->save();

            // Send push notification to client
            if ($booking->user_id) {
                $this->sendPushNotification(
                    $booking->user_id,
                    'Booking Confirmed',
                    'Your booking has been confirmed by staff.',
                    'success',
                    $booking->id
                );
            }

            // Log the confirmation action
            Log::info("Staff confirmed booking {$bookingId}");

            return response()->json([
                'success' => true,
                'message' => 'Booking confirmed successfully',
                'booking_id' => $bookingId
            ]);

        } catch (\Exception $e) {
            Log::error('Error confirming booking: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to confirm booking'
            ], 500);
        }
    }

    /**
     * Reject a booking
     */
    public function rejectBooking(Request $request, $bookingId)
    {
        try {
            $booking = Booking::findOrFail($bookingId);

            // Update booking status to cancelled
            $booking->status = 'cancelled';
            $booking->save();

            // Send push notification to client
            if ($booking->user_id) {
                $this->sendPushNotification(
                    $booking->user_id,
                    'Booking Rejected',
                    'Your booking has been rejected by staff. Please contact us for more information.',
                    'error',
                    $booking->id
                );
            }

            // Log the rejection action
            Log::info("Staff rejected booking {$bookingId}");

            return response()->json([
                'success' => true,
                'message' => 'Booking rejected successfully',
                'booking_id' => $bookingId
            ]);

        } catch (\Exception $e) {
            Log::error('Error rejecting booking: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to reject booking'
            ], 500);
        }
    }

    /**
     * Send push notification to user and save to database
     */
    private function sendPushNotification($userId, $title, $message, $type = 'info', $bookingId = null)
    {
        try {
            // Save notification to database for persistence using custom Notification model
            \App\Models\Notification::create([
                'user_id' => $userId,
                'title' => $title,
                'message' => $message,
                'type' => $type,
                'booking_id' => $bookingId,
                'read' => false,
            ]);

            // Send real-time push notification via Pusher
            $pusher = new Pusher(
                env('PUSHER_APP_KEY'),
                env('PUSHER_APP_SECRET'),
                env('PUSHER_APP_ID'),
                ['cluster' => env('PUSHER_APP_CLUSTER')]
            );

            $pusher->trigger('user-' . $userId, 'notification', [
                'title' => $title,
                'message' => $message,
                'type' => $type,
                'booking_id' => $bookingId,
                'icon' => asset('img/skinlogo.png')
            ]);
        } catch (\Exception $e) {
            Log::error('Push notification failed: ' . $e->getMessage());
        }
    }
}
