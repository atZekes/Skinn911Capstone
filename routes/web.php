<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\Admincontroller;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\CEOController;
use App\Http\Controllers\ChatMessageController;


use Illuminate\Support\Facades\Auth;
Route::get('/', function () {
    if (auth('staff')->check()) {
        return redirect()->route('staff.index');
    }
    if (auth('web')->check()) {
        return redirect()->route('client.home');
    }
    return app(FrontController::class)->index();
})->name('home');
Route::get('/aboutus', [FrontController::class, 'aboutus'])->name('aboutus');
Route::get('/services', [FrontController::class, 'services'])->name('services');
Route::get('/contact', [FrontController::class, 'contact'])->name('contact');
// API endpoint to fetch branches used by the frontend contact page
Route::get('/api/branches', [FrontController::class, 'branchesData'])->name('api.branches');
// API endpoint to fetch staff for a specific branch
Route::get('/branches/{id}/staff', [App\Http\Controllers\BranchStaffController::class, 'index'])->name('branches.staff');


Route::get('/admin', [Admincontroller::class, 'admin'])->name('adminlogin');
Route::post('/admin', [Admincontroller::class, 'login'])->name('admin.adminlogin');

Route::get('/admin/register', [Admincontroller::class, 'showRegisterForm'])->name('admin.register');
Route::post('/admin/register', [Admincontroller::class, 'register'])->name('admin.register.submit');


// Client protected routes - all use the same 'web' guard middleware
Route::middleware('web')->group(function () {
    Route::get('/client/home', [App\Http\Controllers\ClientController::class, 'home'])->name('client.home');
    Route::get('/client/services', [ClientController::class, 'clientServices'])->name('client.services');
    Route::get('/client/booking', [App\Http\Controllers\ClientController::class, 'showBookingForm'])->name('client.booking');
    Route::post('/client/booking', [App\Http\Controllers\ClientController::class, 'submitBooking'])->name('client.booking.submit');
    Route::delete('/client/booking/{id}/cancel', [App\Http\Controllers\ClientController::class, 'cancelBooking'])->name('client.booking.cancel');
    Route::delete('/client/booking/cancel-all', [App\Http\Controllers\ClientController::class, 'cancelAllBookings'])->name('client.booking.cancelAll');
    Route::put('/client/booking/{id}/reschedule', [App\Http\Controllers\ClientController::class, 'rescheduleBooking'])->name('client.booking.reschedule');
    Route::post('/client/booking/{id}/request-refund', [App\Http\Controllers\ClientController::class, 'requestRefund'])->name('client.booking.requestRefund');
    Route::get('/client/calendar', [App\Http\Controllers\ClientController::class, 'calendarViewer'])->name('client.calendar');
    Route::get('/client/dashboard', [App\Http\Controllers\ClientController::class, 'dashboard'])->name('client.dashboard');

    // AJAX endpoints for client dashboard
    Route::get('/api/client/dashboard/stats', [App\Http\Controllers\ClientController::class, 'getDashboardStats'])->name('api.client.dashboard.stats');
    Route::get('/api/client/dashboard/purchased-services', [App\Http\Controllers\ClientController::class, 'getPurchasedServices'])->name('api.client.dashboard.purchased');
    Route::get('/api/client/dashboard/bookings', [App\Http\Controllers\ClientController::class, 'getBookings'])->name('api.client.dashboard.bookings');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/client/purchased-services', [App\Http\Controllers\ClientController::class, 'purchasedServices'])->name('client.purchased_services');

    // Client-specific profile routes (simple edit/update)
    Route::get('/client/profile', [App\Http\Controllers\ClientProfileController::class, 'edit'])->name('client.profile.edit');
    Route::post('/client/profile', [App\Http\Controllers\ClientProfileController::class, 'update'])->name('client.profile.update');

    // Client messages/chat history page
    Route::get('/client/messages', [ChatMessageController::class, 'index'])->name('client.messages');

    // Real-time chat message routes (with session authentication)
    Route::post('/api/chat/send', [ChatMessageController::class, 'sendMessage']);
    Route::get('/api/chat/messages', [ChatMessageController::class, 'getMessages']);
    Route::post('/api/chat/mark-read', [ChatMessageController::class, 'markAsRead']);
    Route::get('/api/chat/unread-count', [ChatMessageController::class, 'getUnreadCount']);
    Route::get('/api/chat/active-chats', [ChatMessageController::class, 'getActiveChats']);

    // Two-Factor Authentication Routes
    Route::get('/two-factor/setup', [App\Http\Controllers\TwoFactorController::class, 'showSetup'])->name('two-factor.setup');
    Route::post('/two-factor/enable', [App\Http\Controllers\TwoFactorController::class, 'enable'])->name('two-factor.enable');
    Route::post('/two-factor/disable', [App\Http\Controllers\TwoFactorController::class, 'disable'])->name('two-factor.disable');

    // 2FA verification (after login, before full access)
    Route::get('/two-factor/verify', [App\Http\Controllers\TwoFactorController::class, 'showVerify'])->name('two-factor.verify');
    Route::post('/two-factor/verify', [App\Http\Controllers\TwoFactorController::class, 'verify'])->name('two-factor.verify.post');
});

// Promo validation (AJAX) - web route fallback
Route::get('/promo/validate', [App\Http\Controllers\ClientController::class, 'validatePromo'])->name('promo.validate');

// API endpoint for client booking slot availability
Route::get('/api/booking/slots', [App\Http\Controllers\ClientController::class, 'getFullSlots'])->name('api.booking.slots');
// API endpoint to fetch authoritative service details (duration, price), optional branch scoping
Route::get('/api/service/{id}', [App\Http\Controllers\ClientController::class, 'serviceDetail'])->name('api.service.detail');

// BotMan endpoint (web widget) - exclude from CSRF so the widget can POST without a session token
Route::match(['get','post'], '/botman', [App\Http\Controllers\BotManController::class, 'handle'])
    ->name('botman.handle')
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);

// Two-Factor Authentication Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/two-factor/setup', [App\Http\Controllers\TwoFactorController::class, 'showSetup'])->name('two-factor.setup');
    Route::post('/two-factor/enable', [App\Http\Controllers\TwoFactorController::class, 'enable'])->name('two-factor.enable');
    Route::post('/two-factor/disable', [App\Http\Controllers\TwoFactorController::class, 'disable'])->name('two-factor.disable');
});

// 2FA verification (after login, before full access)
Route::middleware(['auth'])->group(function () {
    Route::get('/two-factor/verify', [App\Http\Controllers\TwoFactorController::class, 'showVerify'])->name('two-factor.verify');
    Route::post('/two-factor/verify', [App\Http\Controllers\TwoFactorController::class, 'verify'])->name('two-factor.verify.post');
});

require __DIR__.'/auth.php';

// Staff login routes (should be outside middleware)
Route::get('/staff/login', [App\Http\Controllers\StaffController::class, 'loginForm'])->name('staff.login');
Route::get('/staff/availability', [StaffController::class, 'availability'])->middleware('staff')->name('staff.availability');
Route::get('/staff/appointments', [App\Http\Controllers\StaffController::class, 'appointments'])->middleware('staff')->name('staff.appointments');
Route::post('/staff/login', [App\Http\Controllers\StaffController::class, 'login'])->name('staff.login.submit');

// Staff dashboard/profile (protected by staff auth middleware)
Route::post('/staff/logout', function (\Illuminate\Http\Request $request) {
    auth('staff')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/staff/login');
})->name('staff.logout');

// Staff protected routes - all use the same 'staff' middleware
Route::middleware('staff')->group(function () {
    Route::post('/staff/appointments/add', [App\Http\Controllers\StaffController::class, 'addBooking'])->name('staff.addBooking');
    Route::post('/staff/appointments/{id}/reschedule', [App\Http\Controllers\StaffController::class, 'rescheduleBooking'])->name('staff.rescheduleBooking');
    Route::put('/staff/appointments/{id}/confirm-payment', [App\Http\Controllers\StaffController::class, 'confirmPayment'])->name('staff.confirmPayment');
    Route::get('/staff/dashboard', [App\Http\Controllers\StaffController::class, 'index'])->name('staff.index');
    Route::get('/staff/{id}', [App\Http\Controllers\StaffController::class, 'show'])->name('staff.show')->where('id', '[0-9]+');

    Route::post('/staff/appointments/{id}/cancel', [App\Http\Controllers\StaffController::class, 'cancelAppointment'])->name('staff.cancelAppointment');
    Route::patch('/staff/appointments/{id}/complete', [App\Http\Controllers\StaffController::class, 'completeAppointment'])->name('staff.completeAppointment');
    Route::post('/staff/appointments/{id}/send-reminder', [App\Http\Controllers\StaffController::class, 'sendReminder'])->name('staff.sendReminder');
    Route::post('/staff/appointments/{id}/process-refund', [App\Http\Controllers\StaffController::class, 'processRefund'])->name('staff.processRefund');

    Route::post('/staff/pos/record', [App\Http\Controllers\StaffController::class, 'recordTransaction'])->name('staff.pos.record');
    // Staff Interact page (GET)
    Route::get('/staff/interact', [App\Http\Controllers\StaffController::class, 'interact'])->name('staff.interact');
    // Staff Interact form submission (POST)
    Route::post('/staff/interact', [App\Http\Controllers\StaffController::class, 'submitInteract'])->name('staff.interact.submit');
    // AJAX routes for customer interaction
    Route::get('/staff/customer-messages/{customerId}', [App\Http\Controllers\StaffController::class, 'getCustomerMessages'])->name('staff.customer.messages');
    Route::post('/staff/send-reply', [App\Http\Controllers\StaffController::class, 'sendReply'])->name('staff.send.reply');

});

// Admin routes
Route::get('/admin/login', [App\Http\Controllers\Admincontroller::class, 'admin'])->name('admin.login');
Route::post('/admin', [Admincontroller::class, 'login'])->name('admin.adminlogin');
Route::get('/admin/register', [Admincontroller::class, 'showRegisterForm'])->name('admin.register');
Route::post('/admin/register', [Admincontroller::class, 'register'])->name('admin.register.submit');

// Admin protected routes - all use the same 'admin' guard middleware
Route::middleware('admin')->group(function () {
    Route::get('/admin/dashboard', [App\Http\Controllers\Admincontroller::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/promo', [App\Http\Controllers\Admincontroller::class, 'promo'])->name('admin.promo');
    // Promo CRUD for admin
    Route::post('/admin/promos', [App\Http\Controllers\Admincontroller::class, 'storePromo'])->name('admin.promos.store');
    Route::put('/admin/promos/{promo}', [App\Http\Controllers\Admincontroller::class, 'updatePromo'])->name('admin.promos.update');
    Route::delete('/admin/promos/{promo}', [App\Http\Controllers\Admincontroller::class, 'deletePromo'])->name('admin.promos.delete');
    Route::put('/admin/promos/{promo}/toggle', [App\Http\Controllers\Admincontroller::class, 'togglePromo'])->name('admin.promos.toggle');
    // Admin Service Management
    Route::post('/admin/branch/{branch}/service', [App\Http\Controllers\Admincontroller::class, 'addService'])->name('admin.addService');
    // Branch service assignment (assign/unassign services, set branch price)
    Route::post('/admin/branch/{branch}/services', [App\Http\Controllers\Admincontroller::class, 'updateBranchServices'])->name('admin.updateBranchServices');
    // Category management (delete category string from services)
    Route::post('/admin/categories/delete', [App\Http\Controllers\Admincontroller::class, 'deleteCategory'])->name('admin.deleteCategory');
    Route::put('/admin/service/{service}', [App\Http\Controllers\Admincontroller::class, 'updateService'])->name('admin.updateService');
    Route::put('/admin/service/{service}/price', [App\Http\Controllers\Admincontroller::class, 'updateServicePrice'])->name('admin.updateServicePrice');
    Route::delete('/admin/service/{service}', [App\Http\Controllers\Admincontroller::class, 'deleteService'])->name('admin.deleteService');
    Route::get('/admin/user-manage', [App\Http\Controllers\Admincontroller::class, 'userManage'])->name('admin.usermanage');
    Route::get('/admin/branch-management', [App\Http\Controllers\Admincontroller::class, 'branchManagement'])->name('admin.branchmanagement');
    Route::post('/admin/logout', function (\Illuminate\Http\Request $request) {
        auth('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    })->name('admin.logout');
    // Staff password management by admin
    Route::post('/admin/users/{id}/reset-password', [App\Http\Controllers\Admincontroller::class, 'resetStaffPassword'])->name('admin.resetStaffPassword');
    Route::put('/admin/users/{id}/change-password', [App\Http\Controllers\Admincontroller::class, 'changeStaffPassword'])->name('admin.changeStaffPassword');
    Route::post('/admin/create-staff', [Admincontroller::class, 'createStaff'])->name('admin.createStaff');
    Route::put('/admin/branch-management/{branch}', [App\Http\Controllers\Admincontroller::class, 'updateBranch'])->name('admin.updateBranch');
    Route::put('/admin/service/{service}/toggle', [App\Http\Controllers\Admincontroller::class, 'toggleService'])->name('admin.toggleService');
    // Delete staff (admin action)
    Route::delete('/admin/users/{id}', [App\Http\Controllers\Admincontroller::class, 'deleteStaff'])->name('admin.deleteStaff');
    // Toggle staff active/inactive (admin action, scoped to admin's branch)
    Route::put('/admin/users/{id}/toggle-active', [App\Http\Controllers\Admincontroller::class, 'toggleStaffActive'])->name('admin.toggleStaffActive');
    // Toggle branch active/inactive
    Route::put('/admin/branch/{branchId}/toggle', [App\Http\Controllers\Admincontroller::class, 'toggleBranch'])->name('admin.branch.toggle');
    // Package management (branch-scoped)
    Route::get('/admin/branch/{branch}/packages', [App\Http\Controllers\Admincontroller::class, 'branchPackages'])->name('admin.branchPackages');
    Route::post('/admin/branch/{branch}/packages', [App\Http\Controllers\Admincontroller::class, 'storePackage'])->name('admin.packages.store');
    Route::put('/admin/packages/{package}', [App\Http\Controllers\Admincontroller::class, 'updatePackage'])->name('admin.packages.update');
    Route::delete('/admin/packages/{package}', [App\Http\Controllers\Admincontroller::class, 'deletePackage'])->name('admin.packages.delete');
    Route::post('/admin/packages/{package}/services', [App\Http\Controllers\Admincontroller::class, 'attachPackageServices'])->name('admin.packages.attachServices');
    // Booking settings (Admin only)
    Route::get('/admin/booking-settings', [App\Http\Controllers\Admincontroller::class, 'bookingSettings'])->name('admin.booking-settings');
    Route::post('/admin/booking-settings', [App\Http\Controllers\Admincontroller::class, 'updateBookingSettings'])->name('admin.booking-settings.update');
});

// Staff-facing password reset form (token link)
Route::get('/staff/password/reset', [App\Http\Controllers\Admincontroller::class, 'showStaffPasswordResetForm'])->name('staff.password.reset');
Route::post('/staff/password/reset', [App\Http\Controllers\Admincontroller::class, 'submitStaffPasswordReset'])->name('staff.password.reset.submit');


// CEO routes - login routes (outside middleware group)
Route::get('/ceo/login', [App\Http\Controllers\CEOController::class, 'loginForm'])->name('ceo.login');
Route::post('/ceo/login', [App\Http\Controllers\CEOController::class, 'login'])->name('ceo.login.submit');

// CEO protected routes - all use the same 'ceo' guard middleware
Route::middleware('ceo')->group(function () {
    Route::get('/ceo/dashboard', [App\Http\Controllers\CEOController::class, 'dashboard'])->name('ceo.dashboard');
    Route::post('/ceo/compare-branches', [CEOController::class, 'compareBranches'])->name('ceo.compare.branches');
    Route::get('/ceo/adduseradmin', [App\Http\Controllers\CEOController::class, 'addUserAdmin'])->name('ceo.adduseradmin');
    Route::get('/ceo/user-manage', [App\Http\Controllers\CEOController::class, 'userManage'])->name('ceo.usermanage');
    Route::post('/ceo/create-admin', [App\Http\Controllers\CEOController::class, 'storeAdmin'])->name('ceo.createAdmin');
    Route::put('/ceo/user-manage/{user}', [App\Http\Controllers\CEOController::class, 'updateAdmin'])->name('ceo.updateAdmin');
    Route::delete('/ceo/user-manage/{user}', [App\Http\Controllers\CEOController::class, 'deleteAdmin'])->name('ceo.deleteAdmin');
    Route::get('/ceo/branchmanagement', [App\Http\Controllers\CEOController::class, 'branchManagement'])->name('ceo.branchmanagement');
    Route::post('/ceo/create-branch', [App\Http\Controllers\CEOController::class, 'storeBranch'])->name('ceo.createBranch');
    Route::put('/ceo/branch-manage/{branch}', [App\Http\Controllers\CEOController::class, 'updateBranch'])->name('ceo.updateBranch');
    Route::delete('/ceo/branch-manage/{branch}', [App\Http\Controllers\CEOController::class, 'deleteBranch'])->name('ceo.deleteBranch');
    Route::get('/ceo/logout', [CEOController::class, 'logout'])->name('ceo.logout');
    Route::post('/ceo/change-password', [App\Http\Controllers\CEOController::class, 'changePassword'])->name('ceo.changePassword');
    Route::post('/ceo/user-manage/{user}/change-password', [App\Http\Controllers\CEOController::class, 'adminChangePassword'])->name('ceo.adminChangePassword');
    Route::post('/ceo/user-manage/{user}/reset-password', [App\Http\Controllers\CEOController::class, 'resetAdminPassword'])->name('ceo.resetAdminPassword');
});

// Catch-all for old hashed URLs - redirect to their intended pages
Route::get('/{hash}', function ($hash) {
    // Check if this looks like a hash (16 hex characters)
    if (preg_match('/^[a-f0-9]{16}$/i', $hash)) {
        // Extract the intended route from query parameter 'r'
        $intended = request()->query('r');
        
        if ($intended) {
            // Map hashed route names to actual routes
            $routeMap = [
                'home' => '/',
                'services' => '/services',
                'aboutus' => '/aboutus',
                'contact' => '/contact',
                'client.home' => '/client/home',
                'client.services' => '/client/services',
                'client.booking' => '/client/booking',
                'client.dashboard' => '/client/dashboard',
                'client.calendar' => '/client/calendar',
                'client.messages' => '/client/messages',
            ];
            
            // Redirect to the actual route
            if (isset($routeMap[$intended])) {
                return redirect($routeMap[$intended]);
            }
        }
    }
    
    // If not a valid hash or unmapped route, return 404
    abort(404);
})->where('hash', '[a-f0-9]{16}');
