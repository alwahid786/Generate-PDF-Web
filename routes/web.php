<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\AdminController;

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

Route::get('/', function () {
    return view('pages.auth.login');
});

Route::get('/signup', function () {
    return view('pages.auth.signup');
});
Route::get('/login', function () {
    return view('pages.auth.login');
})->name('login');
Route::get('/reset-password', function () {
    return view('pages.auth.reset-password');
});
Route::get('/verify-otp', function () {
    return view('pages.auth.otp');
});
Route::get('/new-password', function () {
    return view('pages.auth.new-password');
});

Route::get('/template', function () {
    return view('pages.pdf-template');
});
Route::get('/coming-soon', function () {
    return view('pages.coming-soon');
});
Route::get('/test', function () {
    return view('emails.contact_us');
});
Route::get('/library', function () {
    return view('pages.library');
});

// Route::get('/lightining-cover', function () {
//     return view('pages.legend-cover');
// });


// API's Function and Routes
Route::post('/register', [AuthController::class, 'signupFunction'])->name('signupFunction');
Route::post('/login', [AuthController::class, 'loginFunction'])->name('loginFunction');
Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgotPassword');
Route::post('/otp-verification', [AuthController::class, 'verifyOtp'])->name('verifyOtp');
Route::post('/password-reset', [AuthController::class, 'resetPassword'])->name('resetPassword');

// Social login
Route::get('google', [AuthController::class, 'redirectToGoogle']);
Route::get('google/callback', [AuthController::class, 'handleGoogleCallback']);

// Auth Protected Routes
Route::middleware('auth')->group(function () {

    // Route::group(['middleware' => ['user']], function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/create-pdf', [PdfController::class, 'createPdfPage'])->name('createPdfPage');
    Route::post('/preview-pdf', [PdfController::class, 'previewPdf'])->name('previewPdf');
    Route::any('/pdf-cover', [PdfController::class, 'pdfCover'])->name('pdfCover');
    // Route::any('/update-profile', [UserController::class, 'updateProfile'])->name('updateProfile');
    Route::any('/delete-package', [UserController::class, 'deletePackage'])->name('deletePackage');
    Route::any('/get-package-data', [UserController::class, 'getPackageData'])->name('getPackageData');
    Route::any('/profile', [UserController::class, 'updateProfile'])->name('updateProfile');
    Route::any('/support', [UserController::class, 'contactUs'])->name('contactUs');
    Route::any('/specification-package', [PdfController::class, 'createPdfPage'])->name('createPdfPage');
    Route::any('/submittal-package', [PdfController::class, 'createPdfPage'])->name('createPdfPage');
    Route::any('/record-drawing', [PdfController::class, 'createPdfPage'])->name('createPdfPage');
    Route::any('/ligtening-legend', [PdfController::class, 'lighteningLegend']);
    Route::post('/ligtening-legend-post', [PdfController::class, 'lighteningLegendPost'])->name('legends.post');
    Route::any('/legends-pdf', [PdfController::class, 'generateLighteningPdf']);
    Route::any('/repair-pdf', [PdfController::class, 'repairPdf']);
    // });

    // admin route

    Route::group(['middleware' => ['admin'], 'prefix' => 'admin/'], function () {
        Route::get('dashboard', [AdminController::class, 'adminDashboard']);
        Route::get('user_request', [AdminController::class, 'userRequest']);
        Route::post('update_status', [AdminController::class, 'updateStatus'])->name('update.status');
        Route::any('/delete-user', [AdminController::class, 'deleteUser'])->name('deleteUser');
        Route::post('/update-password', [AdminController::class, 'updatePassword'])->name('updatePassword');
    });
});
