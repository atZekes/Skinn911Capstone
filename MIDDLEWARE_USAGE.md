# Middleware Usage Guide for Skin911

## How to Use Role-Based Middleware

### 1. Single Route Protection
```php
// Only staff can access this route
Route::get('/staff/dashboard', [StaffController::class, 'dashboard'])->middleware('staff');

// Only admin can access this route  
Route::get('/admin/settings', [AdminController::class, 'settings'])->middleware('admin');

// Only CEO can access this route
Route::get('/ceo/reports', [CEOController::class, 'reports'])->middleware('ceo');

// Only clients can access this route
Route::get('/client/profile', [ClientController::class, 'profile'])->middleware('client');
```

### 2. Group Route Protection
```php
// Protect multiple staff routes at once
Route::middleware('staff')->group(function () {
    Route::get('/staff/dashboard', [StaffController::class, 'dashboard']);
    Route::get('/staff/appointments', [StaffController::class, 'appointments']);
    Route::post('/staff/booking', [StaffController::class, 'createBooking']);
});

// Protect multiple CEO routes at once
Route::middleware('ceo')->group(function () {
    Route::get('/ceo/dashboard', [CEOController::class, 'dashboard']);
    Route::get('/ceo/branch-management', [CEOController::class, 'branchManagement']);
    Route::get('/ceo/user-management', [CEOController::class, 'userManagement']);
});
```

### 3. Multiple Middleware (Advanced)
```php
// Multiple checks - user must be logged in AND be a staff member
Route::get('/staff/secure', [StaffController::class, 'secure'])
    ->middleware(['auth', 'staff']);
```

## What Each Middleware Does

### StaffMiddleware
- Checks if user is logged in
- Checks if user has role = 'staff'
- Redirects to login if not logged in
- Shows error if not staff

### AdminMiddleware  
- Checks if user is logged in
- Checks if user has role = 'admin'
- Redirects to login if not logged in
- Shows error if not admin

### CeoMiddleware
- Checks if user is logged in
- Checks if user has role = 'ceo'
- Redirects to login if not logged in
- Shows error if not CEO

### ClientMiddleware
- Checks if user is logged in
- Checks if user has role = 'client'
- Redirects to login if not logged in
- Shows error if not client

## User Role Values in Database
Make sure your users table has these role values:
- 'staff' - for staff members
- 'admin' - for administrators  
- 'ceo' - for CEO users
- 'client' - for regular clients/customers
