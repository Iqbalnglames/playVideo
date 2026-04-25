<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Route;

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
Route::get('/login', [AuthController::class, 'showLogin'])->name('login.show');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware(['auth'])->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/profile',[UserController::class, 'profile'])->name('profile');
    Route::get('/profile/edit',[UserController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile/update',[UserController::class, 'updateProfile'])->name('profile.update');
    Route::get('/profile/edit-password',[UserController::class, 'passwordChange'])->name('profile.password.edit');
    Route::put('/profile/update-password',[UserController::class, 'updatePassword'])->name('profile.password.update');

    Route::get('/',[VideoController::class, 'indexVideo'])->name('video');
    Route::get('/video/{video}',[VideoController::class, 'viewVideo'])->name('video.view');
});

Route::middleware(['auth','role:customer'])->group(function () {

    Route::post('/video-reqs-access/{video}',[VideoController::class, 'videoRequestAccess'])->name('video-request-access');

});

Route::middleware(['auth','role:admin'])->group(function () {

    Route::get('/video-data',[VideoController::class, 'videoData'])->name('video.list');
    Route::get('/video-edit/{video}',[VideoController::class, 'editVideo'])->name('video.edit');
    Route::put('/video-update/{video}',[VideoController::class, 'updateVideo'])->name('video.update');
    Route::delete('/video-delete/{video}',[VideoController::class, 'deleteVideo'])->name('video.delete');
    Route::get('/upload-video',[VideoController::class, 'uploadVideo'])->name('video.upload');
    Route::post('/store-video',[VideoController::class, 'storeVideo'])->name('video.store');

    Route::get('/video-reqs',[VideoController::class, 'videoRequest'])->name('video-request');
    Route::patch('/video-reqs-access-approve/{videoAccess}',[VideoController::class, 'approveAccess'])->name('approve-request-access');
    Route::patch('/video-reqs-access-deny/{videoAccess}',[VideoController::class, 'denyAccess'])->name('deny-request-access');

    Route::get('/customer',[UserController::class, 'customer'])->name('customer');
    Route::get('/create-customer',[UserController::class, 'createCustomer'])->name('customer.create');
    Route::post('/store-customer',[UserController::class, 'storeCustomer'])->name('customer.store');
    Route::get('/edit-customer/{customer}',[UserController::class, 'editCustomer'])->name('customer.edit');
    Route::put('/update-customer/{customer}',[UserController::class, 'updateCustomer'])->name('customer.update');
    Route::delete('/delete-customer/{customer}',[UserController::class, 'deleteCustomer'])->name('customer.delete');

});
