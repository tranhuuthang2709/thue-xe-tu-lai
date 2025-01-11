<?php

use App\Http\Controllers\Admin\Admin_HomeController;
use App\Http\Controllers\Admin\BookingManageController;
use App\Http\Controllers\Admin\brandController;
use App\Http\Controllers\Admin\CarController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\RefundManageController;
use App\Http\Controllers\Admin\UserManageController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\GoogleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ListCarController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Admin\DamageReportController;
use App\Http\Controllers\registerLessorController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/list_car', [ListCarController::class, 'index'])->name('list_car');
Route::get('detail/{id}', [HomeController::class, 'detail'])->name('detail');
Route::get('/search', [ListCarController::class, 'search'])->name('search');

Route::middleware('auth')->group(function () {
    Route::post('addcomment/{car_id}', [CommentController::class, 'Addcomment'])->name('addcomment');
    Route::put('/comment/edit/{id}', [CommentController::class, 'edit'])->name('comment.edit');
    Route::get('/comment/delete/{id}', [CommentController::class, 'delete'])->name('comment.delete');

    Route::get('favorite/{id}', [HomeController::class, 'favorite'])->name('favorite');
    Route::get('/favotite-cars', [HomeController::class, 'favoriteCars'])->name('favorite_cars');

    Route::get('change-password', [UserController::class, 'change_password'])->name('change_password');
    Route::post('change-password', [UserController::class, 'check_change_password']);

    Route::get('bookings', [BookingController::class, 'bookings'])->name('user.bookings');
    Route::get('bookings_detail/{id}', [BookingController::class, 'bookings_detail'])->name('user.bookings_detail');
    Route::get('/booking_cancel/{id}', action: [BookingController::class, 'cancelBooking'])->name('user.bookings_cancel');
    Route::post('/booking/{id}/submit-refund', [BookingController::class, 'submitRefundInfo'])->name('user.submit_refund_info');

    Route::prefix('cart')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('cart.index');
        Route::get('/add/{car}', [CartController::class, 'add'])->name('cart.add');
        Route::get('/cart/edit/{id}', [CartController::class, 'edit'])->name('cart.edit');
        Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
        Route::get('/delete/{id}', [CartController::class, 'delete'])->name('cart.delete');
        Route::get('/clear', [CartController::class, 'clear'])->name('cart.clear');
    });

    Route::post('vnpay_payment', [PaymentController::class, 'vnpay_payment'])->name('vnpay_payment')->middleware('auth');
    Route::get('/vnpay_return', [PaymentController::class, 'vnpay_return'])->name('vnpay_return');

    Route::get('/profile', [UserController::class, 'edit'])->name('profile');
    Route::post('/profile', [UserController::class, 'update']);

    Route::get('/register-as-lessor', [registerLessorController::class, 'showFormRegisterLessor'])->name('lessor.register');
    Route::post('/register-as-lessor', [registerLessorController::class, 'registerAsLessor']);
});

Route::get('login', [UserController::class, 'login'])->name('login');
Route::post('login', [UserController::class, 'check_login']);


Route::get('logout', [UserController::class, 'logout'])->name('logout');

Route::get('register', [UserController::class, 'register'])->name('register');
Route::post('register', [UserController::class, 'check_register']);

Route::get('verify-account/{email}', [UserController::class, 'verify'])->name('verify');


Route::get('forgot-password', [UserController::class, 'forgot_password'])->name('forgot_password');
Route::post('forgot-password', [UserController::class, 'check_forgot_password']);


Route::get('reset-password/{token}', [UserController::class, 'reset_password'])->name('reset_password');
Route::post('reset-password/{token}', [UserController::class, 'check_reset_password']);

//login google
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/home', [Admin_HomeController::class, 'index'])->name('admin.home');
    Route::middleware('checkRole:admin')->group(function () {
        Route::resource('brand', brandController::class);
        Route::resource('category', controller: CategoryController::class);
        Route::resource('users', UserManageController::class, ['as' => 'admin']);
    });
    Route::middleware('checkRole:admin-lessor')->group(function () {
        Route::get('/admin/bookings/rented-cars', [BookingManageController::class, 'listRentedCars'])->name('booking.rentedCars');
        Route::resource('car', CarController::class);
        Route::get('delete-img/{id}', [CarController::class, 'destroyimage'])->name('car.deleteImage');
        Route::get('/update-status-car/{id}', [CarController::class, 'editStatus'])->name('car.editStatus');
        Route::put('/edit-status-car{id}', [CarController::class, 'updateStatus'])->name('car.updateStatus');
    });
    Route::middleware('checkRole:admin-employee')->group(function () {
        Route::get('/booking-detail/{booking}', [BookingManageController::class, 'booking_detail'])->name('booking.detail');
        Route::get('/bookings', [BookingManageController::class, 'index'])->name('booking.index');
        Route::post('/booking/{id}/update-pickup-status', [BookingManageController::class, 'updatePickupStatus'])->name('booking.updatePickupStatus');
        Route::get('list-refund', [RefundManageController::class, 'listRefund'])->name('booking.listRefund');
        Route::post('/booking/{id}/update-status-refund', [RefundManageController::class, 'updateStatusRefund'])->name('refund.updateStatusRefund');
        Route::get('/booking/{id}/return', [BookingManageController::class, 'returnCarPage'])->name('booking.returnCarPage');
        Route::post('/booking/{id}/return', [BookingManageController::class, 'processReturn'])->name('booking.processReturn');
        Route::put('/damage-reports/{id}/update-payment-status', [DamageReportController::class, 'updatePaymentStatus'])->name('damageReports.updatePaymentStatus');
        Route::post('/booking/{id}/update-return-status', [BookingManageController::class, 'updateReturnStatus'])->name('booking.updateReturnStatus');
        Route::post('/booking/{bookingDetailId}/damage-report', [BookingManageController::class, 'storeDamageReport'])->name('booking.storeDamageReport');
        // xuất hóa đơn
        Route::get('booking/{booking}/invoice', [BookingManageController::class, 'generateInvoice'])->name('booking.generateInvoice');
    });
    Route::middleware('checkRole:admin-lessor-employee')->group(function () {
        Route::get('/list-return-car', [BookingManageController::class, 'returnCarPage'])->name('booking.listReturnCar');
        Route::get('/return-car-detail/{id}', [BookingManageController::class, 'showReturnCarDetail'])->name('booking.showReturnCarDetail');
        Route::get('/damage-reports', [DamageReportController::class, 'index'])->name('listReport');
    });
});
