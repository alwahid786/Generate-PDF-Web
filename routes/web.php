<?php

use Illuminate\Support\Facades\Route;

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
Route::get('/dashboard', function () {
    return view('pages.dashboard');
});
Route::get('/pdf-cover', function () {
    return view('pages.pdf-cover');
});
Route::get('/create-pdf', function () {
    return view('pages.create-pdf');
});
Route::get('/lighting-legend', function () {
    return view('pages.lighting-legend');
});
Route::get('/record-drawings', function () {
    return view('pages.record-drawings');
});
Route::get('/spec-package', function () {
    return view('pages.spec-package');
});
Route::get('/submittal-package', function () {
    return view('pages.submittal-package');
});
Route::get('/lighting-output', function () {
    return view('pages.lighting-output');
});
Route::get('/support', function () {
    return view('pages.support');
});
Route::get('/profile', function () {
    return view('pages.profile');
});
Route::get('/pdf-template', function () {
    return view('pages.pdf-template');
});
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
