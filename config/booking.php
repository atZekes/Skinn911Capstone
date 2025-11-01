<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Booking Configuration
    |--------------------------------------------------------------------------
    |
    | Here you can configure various booking-related settings for the
    | spa management system.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Minimum Advance Days
    |--------------------------------------------------------------------------
    |
    | The minimum number of days in advance that clients must book their
    | appointments. Staff members can override this restriction when creating
    | bookings through the staff interface.
    |
    | Default: 2 days
    |
    */
    'minimum_advance_days' => (int) env('BOOKING_MINIMUM_ADVANCE_DAYS', 2),

    /*
    |--------------------------------------------------------------------------
    | Maximum Advance Days
    |--------------------------------------------------------------------------
    |
    | The maximum number of days in advance that bookings can be made.
    | This prevents clients from booking too far into the future.
    |
    | Default: 60 days (2 months)
    |
    */
    'maximum_advance_days' => (int) env('BOOKING_MAXIMUM_ADVANCE_DAYS', 60),

    /*
    |--------------------------------------------------------------------------
    | Default Slot Capacity
    |--------------------------------------------------------------------------
    |
    | The default number of concurrent bookings allowed per time slot
    | when a branch doesn't have a specific capacity setting.
    |
    | Default: 5
    |
    */
    'default_slot_capacity' => (int) env('BOOKING_DEFAULT_SLOT_CAPACITY', 5),

    /*
    |--------------------------------------------------------------------------
    | Staff Override
    |--------------------------------------------------------------------------
    |
    | Whether staff members can override booking restrictions when creating
    | appointments through the staff interface.
    |
    | Default: true
    |
    */
    'allow_staff_override' => (bool) env('BOOKING_ALLOW_STAFF_OVERRIDE', true),
];
