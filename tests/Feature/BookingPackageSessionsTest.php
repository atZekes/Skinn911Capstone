<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Branch;
use App\Models\Service;
use App\Models\Booking;
use App\Models\ClientPackageSession;
use App\Models\Package;
use App\Models\PackageBooking;

class BookingPackageSessionsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function creating_a_booking_and_confirming_payment_creates_client_package_session_for_multi_session_service()
    {
        // Seed a branch, service (multi-session), staff and client
        $branch = Branch::factory()->create();
        $service = Service::factory()->create(['default_sessions' => 3]);
        $user = User::factory()->create(['role' => 'client']);
        $staff = User::factory()->create(['role' => 'staff', 'branch_id' => $branch->id]);

        // Create a booking
        $booking = Booking::create([
            'user_id' => $user->id,
            'branch_id' => $branch->id,
            'service_id' => $service->id,
            'date' => now()->addDays(3)->format('Y-m-d'),
            'time_slot' => '10:00-11:00',
            'status' => 'active',
            'payment_method' => 'cash',
            'payment_status' => 'unpaid',
        ]);

        // Confirm payment using the staff controller route
        $this->actingAs($staff, 'staff')->put(route('staff.confirmPayment', $booking->id));

        // Assert client package session created with correct sessions
        $this->assertDatabaseHas('client_package_sessions', [
            'booking_id' => $booking->id,
            'user_id' => $user->id,
            'service_id' => $service->id,
            'branch_id' => $branch->id,
            'total_sessions' => 3,
            'sessions_remaining' => 3,
        ]);
    }

    /** @test */
    public function package_booking_creates_package_booking_and_client_package_sessions()
    {
        $branch = Branch::factory()->create();
        $service = Service::factory()->create(['default_sessions' => 5]);
        $pkg = Package::create(['name' => 'HIFU Package', 'price' => 5000, 'branch_id' => $branch->id]);
        $pkg->services()->attach($service->id, ['quantity' => 1]);

        $user = User::factory()->create(['role' => 'client']);
        $staff = User::factory()->create(['role' => 'staff', 'branch_id' => $branch->id]);

        // Create booking for package
        $booking = Booking::create([
            'user_id' => $user->id,
            'branch_id' => $branch->id,
            'package_id' => $pkg->id,
            'date' => now()->addDays(4)->format('Y-m-d'),
            'time_slot' => '10:00-11:00',
            'status' => 'active',
            'payment_method' => 'cash',
            'payment_status' => 'unpaid'
        ]);

        // Confirm payment to trigger package creation
        $this->actingAs($staff, 'staff')->put(route('staff.confirmPayment', $booking->id));

        // Assert PackageBooking created
        $this->assertDatabaseHas('package_bookings', [
            'user_id' => $user->id,
            'branch_id' => $branch->id,
            'total_credits' => 5,
            'remaining_credits' => 5,
        ]);

        // Assert ClientPackageSession created for the service
        $this->assertDatabaseHas('client_package_sessions', [
            'booking_id' => $booking->id,
            'user_id' => $user->id,
            'service_id' => $service->id,
            'total_sessions' => 5,
            'sessions_remaining' => 5,
        ]);
    }

    /** @test */
    public function staff_booking_of_package_session_deducts_and_refund_restores_credit()
    {
        $branch = Branch::factory()->create();
        $service = Service::create(['name' => 'Test Service', 'default_sessions' => 5, 'price' => 1000]);
        $pkg = Package::create(['name' => 'HIFU', 'price' => 5000, 'branch_id' => $branch->id]);
        $pkg->services()->attach($service->id, ['quantity' => 1]);

        $user = User::factory()->create(['role' => 'client']);
        $staff = User::factory()->create(['role' => 'staff', 'branch_id' => $branch->id]);

        $booking = Booking::create([
            'user_id' => $user->id,
            'branch_id' => $branch->id,
            'package_id' => $pkg->id,
            'date' => now()->addDays(4)->format('Y-m-d'),
            'time_slot' => '11:00-12:00',
            'status' => 'active',
            'payment_method' => 'cash',
            'payment_status' => 'unpaid'
        ]);

        // Confirm payment and create sessions
        $this->actingAs($staff, 'staff')->put(route('staff.confirmPayment', $booking->id));
        $cps = ClientPackageSession::where('booking_id', $booking->id)->first();
        $this->assertNotNull($cps);
        $this->assertEquals(5, $cps->sessions_remaining);

        // Staff books a session from the package and it deducts a credit
        $res = $this->actingAs($staff, 'staff')->post(route('staff.package.book', $cps->id), ['date' => now()->addDays(5)->format('Y-m-d'), 'time_slot' => '11:00-12:00']);
        $cps->refresh();
        $this->assertEquals(4, $cps->sessions_remaining);

        // Staff cancels the booking (refund) - find the booking created by bookPackageSession
        $booked = Booking::where('package_booking_id', null)->where('user_id', $user->id)->orderBy('created_at', 'desc')->first();
        $this->actingAs($staff, 'staff')->post(route('staff.package.cancel', $booked->id));
        $cps->refresh();
        $this->assertEquals(5, $cps->sessions_remaining);
    }
}
