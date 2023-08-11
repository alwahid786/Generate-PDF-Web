<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PdfController;

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
// Route::get('/dashboard', function () {
//     return view('pages.dashboard');
// });

// Route::get('/pdf-cover', function () {
//     return view('pages.pdf-cover');
// })->name('coverPage');

Route::get('/signup', function () {
    return view('pages.auth.signup');
});
Route::get('/login', function () {
    return view('pages.auth.login');
});
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


// API's Function and Routes
Route::post('/register', [AuthController::class, 'signupFunction'])->name('signupFunction');
Route::post('/login', [AuthController::class, 'loginFunction'])->name('loginFunction');
Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgotPassword');
Route::post('/otp-verification', [AuthController::class, 'verifyOtp'])->name('verifyOtp');
Route::post('/password-reset', [AuthController::class, 'resetPassword'])->name('resetPassword');

// Auth Protected Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [PdfController::class, 'getpdfdetail']);
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/create-pdf', [PdfController::class, 'createPdfPage'])->name('createPdfPage');
    Route::post('/preview-pdf', [PdfController::class, 'previewPdf'])->name('previewPdf');
    Route::any('/pdf-cover', [PdfController::class, 'pdfCover'])->name('pdfCover');
});
