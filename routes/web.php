<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\Admin;
use App\Http\Controllers\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Company\DashboardController;
use App\Http\Controllers\Company\VehicleController;
use App\Http\Controllers\Company\CompanyController;
use App\Http\Controllers\Company\RouteController;
use App\Http\Controllers\Company\CompanyScheduleController;

use App\Http\Controllers\Admin\VehicleTypeClassController;
use App\Http\Controllers\Admin\FareController;

use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ReviewController;

use App\Http\Controllers\User\MyTicketController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Company\CompanyProfileController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\SeatFormatController;


use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// use Illuminate\Support\Facades\Mail;
// use App\Mail\TicketMail;
// use App\Models\Booking;

// Route::get('/test-mail', function () {
//     $booking = Booking::latest()->first(); // Or use a specific one
//     Mail::to('neupanesarthak3000@gmail.com')->send(new TicketMail($booking));
//     return "Mail Sent";
// });



// 1. Show verification notice
Route::get('/email/verify', function () {
    return view('auth.verify-email'); // Create this Blade file if it doesn't exist
})->middleware('auth')->name('verification.notice');

// 2. Handle the email verification link click
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill(); // Mark user as verified
    return redirect('/'); // Change to wherever you want to redirect after verification
})->middleware(['auth', 'signed'])->name('verification.verify');

// 3. Resend verification email
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/', [BookingController::class, 'welcome'])->name('welcome');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/terms', [PageController::class, 'terms'])->name('terms');
Auth::routes(['verify' => true]);

Route::get('/home', [BookingController::class, 'welcome'])->name('welcome');



Route::post('/search', [ScheduleController::class, 'search'])->name('search.schedules');




//  --------------------------------------------------------- ADMIN ---------------------------------------------------------
Route::middleware(['admin', 'verified'])->group(function () {

    //admin dashboard

    Route::get('/admin/dashboard', [Admin\DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/profile', [Admin\AdminProfileController::class, 'profile'])->name('admin.profile');
    Route::get('/admin/profile/edit', [Admin\AdminProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/admin/profile/update', [Admin\AdminProfileController::class, 'update'])->name('admin.profile.update');

    // Forms Route
    Route::get('/admin/forms', function () {
        return view('admin.home'); // Ensure you have a home.blade.php file in resources/views/admin
    })->name('forms');

    // Tables Route
    Route::get('/admin/tables', function () {
        return view('admin.home'); // Ensure you have a home.blade.php file in resources/views/admin
    })->name('tables');

    Route::get('/admin/notifications', function () {
        return view('admin.home'); // Ensure you have a home.blade.php file in resources/views/admin
    })->name('notifications');

    Route::get('/admin/typography', function () {
        return view('admin.home'); // Ensure you have a home.blade.php file in resources/views/admin
    })->name('typography');

    Route::get('/admin/icons', function () {
        return view('admin.home'); // Ensure you have a home.blade.php file in resources/views/admin
    })->name('icons');


    //route for admin/locations
    Route::get('admin/location', [Admin\LocationController::class, 'index'])->name('admin.location');
    Route::get('admin/location/add', [Admin\LocationController::class, 'create'])->name('admin.location.add');
    Route::post('admin/location/store', [Admin\LocationController::class, 'store'])->name('admin.location.store');
    Route::get('admin/location/edit/{id}', [Admin\LocationController::class, 'edit'])->name('admin.location.edit');
    Route::put('admin/location/update/{id}', [Admin\LocationController::class, 'update'])->name('admin.location.update');
    Route::delete('admin/location/delete/{id}', [Admin\LocationController::class, 'destroy'])->name('admin.location.delete');




    // Route for admin.route
    Route::get('/admin/route', [Admin\RouteController::class, 'index'])->name('admin.route');
    Route::get('/admin/route/add', [Admin\RouteController::class, 'create'])->name('admin.route.add');
    Route::post('/admin/route/store', [Admin\RouteController::class, 'store'])->name('admin.route.store');
    Route::get('/admin/route/edit/{id}', [Admin\RouteController::class, 'edit'])->name('admin.route.edit');
    Route::put('/admin/route/update/{id}', [Admin\RouteController::class, 'update'])->name('admin.route.update');
    Route::delete('/admin/route/delete/{id}', [Admin\RouteController::class, 'destroy'])->name('admin.route.delete');



    //routes for vehicle type
    Route::prefix('admin/vehicle-types')->name('admin.vehicle_type.')->controller(Admin\VehicleTypeController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/add', 'create')->name('add');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::put('/update/{id}', 'update')->name('update');
        Route::delete('/delete/{id}', 'destroy')->name('delete');
    });

    //routes for vehicle class
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/vehicle-classes', [Admin\VehicleClassController::class, 'index'])->name('vehicle_class');
        Route::get('/vehicle-classes/add', [Admin\VehicleClassController::class, 'create'])->name('vehicle_class.add');
        Route::post('/vehicle-classes/store', [Admin\VehicleClassController::class, 'store'])->name('vehicle_class.store');
        Route::get('/vehicle-classes/edit/{id}', [Admin\VehicleClassController::class, 'edit'])->name('vehicle_class.edit');
        Route::put('/vehicle-classes/update/{id}', [Admin\VehicleClassController::class, 'update'])->name('vehicle_class.update');
        Route::delete('/vehicle-classes/delete/{id}', [Admin\VehicleClassController::class, 'destroy'])->name('vehicle_class.delete');
    });


    Route::get('/admin/bus-company', [Admin\BusCompanyController::class, 'index'])->name('admin.bus_company');
    Route::put('/admin/approve-company/{id}', [Admin\BusCompanyController::class, 'approveCompany'])->name('admin.approveCompany');
    Route::put('/admin/company/reject/{id}', [Admin\BusCompanyController::class, 'rejectCompany'])->name('admin.rejectCompany');

    Route::get('/admin/bus-company/details/{id}', [Admin\BusCompanyController::class, 'show'])->name('admin.company.details');
    Route::patch('/admin/company/{id}/toggle-status', [Admin\BusCompanyController::class, 'toggleStatus'])->name('admin.company.toggleStatus');

    Route::get('/admin/bus-company/details/{id}/schedules', [Admin\BusCompanyController::class, 'schedule'])
    ->name('admin.company.details.schedules');

    Route::prefix('admin')->group(function () {
        Route::get('/fare', [VehicleTypeClassController::class, 'index'])->name('admin.fare.index');
        Route::get('/fare/create', [VehicleTypeClassController::class, 'create'])->name('admin.fare.create');
        Route::post('/fare', [VehicleTypeClassController::class, 'store'])->name('admin.fare.store');
        Route::put('/fare/{id}', [VehicleTypeClassController::class, 'update'])->name('admin.fare.update');
        Route::delete('/fare/{id}', [VehicleTypeClassController::class, 'destroy'])->name('admin.fare.destroy');


        // Route::resource('fare', FareController::class, )->names('admin.fare');
    });


    

    // Index - List all seat formats
    Route::get('seat_formats', [SeatFormatController::class, 'index'])->name('admin.seat_formats.index');

    // Create - Show form to create new seat format
    Route::get('seat_formats/create', [SeatFormatController::class, 'create'])->name('admin.seat_formats.create');

    // Store - Save new seat format
    Route::post('seat_formats', [SeatFormatController::class, 'store'])->name('admin.seat_formats.store');
    Route::get('/admin/seat_formats/{format}/layout', [SeatFormatController::class, 'seatLayoutPartial'])->name('admin.seat_formats.layout');

    // Edit - Show form to edit seat format
    Route::get('seat_formats/{id}/edit', [SeatFormatController::class, 'edit'])->name('admin.seat_formats.edit');

    // Update - Save updated seat format
    Route::put('seat_formats/{id}', [SeatFormatController::class, 'update'])->name('admin.seat_formats.update');

    // Delete - Remove seat format
    Route::delete('seat_formats/{id}', [SeatFormatController::class, 'destroy'])->name('admin.seat_formats.destroy');
    
    

});


// -------------------------------------------------------- USER --------------------------------------------------------
Route::middleware(['user', 'verified'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/company/add', [CompanyController::class, 'create'])->name('company.add');
    Route::post('/company/add', [CompanyController::class, 'store'])->name('company.store');
    

    Route::get('/api/seats/{schedule}', [BookingController::class, 'seatLayoutPartial']);
    // Route::get('/booking', [BookingController::class, 'index'])->name('booking.index');  // Display booking form
    // Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');  // Store booking

    // Route::get('/booking/details', [BookingController::class, 'details'])->name('booking.details');
    // Route::get('/booking/storedetails', [BookingController::class, 'storedetails'])->name('booking.storedetails');

    Route::get('/booking', [BookingController::class, 'index'])->name('booking.index');  // Display booking form
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');  // Store booking

Route::get('/booking/details', [BookingController::class, 'details'])->name('booking.details');
Route::post('/booking/storedetails', [BookingController::class, 'storedetails'])->name('booking.storedetails'); // POST

Route::get('/booking/success', [BookingController::class, 'success'])->name('booking.success');

    Route::get('/booking/payment/request', [BookingController::class, 'paymentRequest'])->name('payment.request');
Route::get('/booking/payment/success', [BookingController::class, 'paymentSuccess'])->name('payment.success');
Route::get('/booking/payment/fail', [BookingController::class, 'paymentFail'])->name('payment.fail');

    Route::put('/my-tickets/{id}/cancel', [MyTicketController::class, 'cancel'])->name('my-tickets.cancel');

   
    Route::get('/my-tickets', [MyTicketController::class, 'index'])->name('my.tickets');
    Route::get('/reviews', [ReviewController::class, 'index'])->name('review');

   
    
    Route::get('/reviews/create', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
   Route::get('/reviews/{review}', [ReviewController::class, 'show'])->name('reviews.show');




    Route::get('/my-tickets/{id}/download-pdf', [MyTicketController::class, 'generatePdf'])->name('my-tickets.download-pdf');
});


//--------------------------------------------------------- COMPANY ---------------------------------------------------------------
Route::middleware(['bus', 'verified'])->group(function () {
    Route::prefix('/company')->name('company.')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/profile', [CompanyProfileController::class, 'edit'])->name('profile');
        Route::post('/profile/update', [CompanyProfileController::class, 'update'])->name('profile.update');

        
        // Vehicles 
        Route::get('/vehicles', [VehicleController::class, 'index'])->name('vehicles');
        Route::get('/vehicles/add', [VehicleController::class, 'create'])->name('vehicles.add');
        Route::post('/vehicles/store', [VehicleController::class, 'store'])->name('vehicles.store');
        Route::get('/vehicles/{vehicle}/edit', [VehicleController::class, 'edit'])->name('vehicles.edit');
        Route::put('/vehicles/{vehicle}', [VehicleController::class, 'update'])->name('vehicles.update');
        Route::delete('/vehicles/{vehicle}', [VehicleController::class, 'destroy'])->name('vehicles.destroy');

        //Routes
        Route::get('/routes',             [RouteController::class, 'index'])->name('routes.index');
        Route::get('/routes/create',        [RouteController::class, 'create'])->name('routes.create');
        Route::post('/routes',              [RouteController::class, 'store'])->name('routes.store');
        Route::get('/routes/{vehicle}/edit',[RouteController::class, 'edit'])->name('routes.edit');
        Route::put('/routes/{vehicle}',     [RouteController::class, 'update'])->name('routes.update');
        Route::delete('/routes/{vehicle}',  [RouteController::class, 'destroy'])->name('routes.destroy');
        


        Route::get('/schedules', [CompanyScheduleController::class, 'index'])->name('schedules');
        Route::get('/schedules/create', [CompanyScheduleController::class, 'create'])->name('schedules.create');
        Route::post('/schedules/store', [CompanyScheduleController::class, 'store'])->name('schedules.store');
        Route::get('/schedules/{schedule}/edit', [CompanyScheduleController::class, 'edit'])->name('schedules.edit');
        Route::put('/schedules/{schedule}', [CompanyScheduleController::class, 'update'])->name('schedules.update');
        Route::delete('/schedules/{schedule}', [CompanyScheduleController::class, 'destroy'])->name('schedules.destroy');

        Route::patch('/schedules/{id}/toggle-status', [CompanyScheduleController::class, 'toggleStatus'])->name('schedules.toggleStatus');

        Route::get('/schedules/history', [CompanyScheduleController::class, 'history'])->name('schedules.history');
        
        Route::get('/schedules/{id}/bookings', [CompanyScheduleController::class, 'showBookings'])->name('schedules.bookings');
        // Route::get('/schedules/bookings/create', [CompanyScheduleController::class, 'createBooking'])->name('schedules.bookings.create');

        Route::get('/schedules/bookings/create', [CompanyScheduleController::class, 'createBooking'])->name('schedules.bookings.create');
        Route::post('/schedules/bookings/store', [CompanyScheduleController::class, 'storeBooking'])->name('schedules.bookings.store');

        // Company Reviews Routes
        Route::prefix('/reviews')->name('reviews.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Company\ReviewController::class, 'index'])
                ->name('index');
            
            Route::get('/{review}', [\App\Http\Controllers\Company\ReviewController::class, 'show'])
                ->name('show');
        });
    
    });

        





    
});






