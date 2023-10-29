<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IRSController;
use App\Http\Controllers\KHSController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\Login\LoginController;
use App\Http\Controllers\MahasiswaTaskController;
use App\Http\Controllers\PKLController;

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


Route::middleware('guest')-> group(function () {
    Route::get('/', function () {
        return redirect('/login');
    });

    Route::get('/login', [LoginController::class, 'index'])->name('login');

    Route::post('/login', [LoginController::class, 'authenticate']);
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [LoginController::class,'dashboard'])->middleware('is.first.login');

    Route::post('/logout', [LoginController::class, 'logout']);

    Route::get('/dosen', [LoginController::class, 'dosen'])->middleware('user.role:dosenwali');

    Route::get('/photo/{photoname}', [FileController::class, 'showProfilePhoto'])->where('photoname', '.*');
    Route::get('/scan-irs/{filename}', [FileController::class, 'showIRS'])->where('filename', '.*');
    Route::get('/scan-khs/{filename}', [FileController::class, 'showKHS'])->where('filename', '.*');
});

Route::middleware(['auth', 'user.role:operator'])->group(function () {
    Route::resource('/akunMHS', MahasiswaController::class);
    
    Route::delete('/akunMHS/{nim}', [MahasiswaController::class, 'destroy']);
    Route::post('/akunMHS/importExcel', [MahasiswaController::class, 'storeImport']);
    Route::post('/akunMHS/exportExcel', [MahasiswaController::class, 'exportData']);
    Route::get('/ajaxAkunMHS', [MahasiswaController::class,'updateTableMhs']);
});


Route::middleware(['auth','user.role:mahasiswa'])->group(function () {
    Route::get('/firstLogin', [MahasiswaTaskController::class,'firstLogin']);
    Route::middleware('is.first.login')->group(function () {
        // error role lain tidak bisa ke dashboard
        // Route::get('/dashboard', [LoginController::class,'dashboard']);
    });

    Route::get('/profile', [MahasiswaController::class, 'viewProfile']);
    Route::get('/profile-edit', [MahasiswaController::class, 'editProfile']);
    Route::put('/profile/edit/{mahasiswa}', [MahasiswaController::class, 'updateProfile']);
    Route::get('/irs', [IRSController::class, 'index']);
    Route::put('/irs', [IRSController::class, 'updateOrInsert']);
    Route::get('/khs', [KHSController::class, 'index']);
    Route::put('/khs', [KHSController::class, 'updateOrInsert']);
    Route::get('/pkl', [PKLController::class, 'index']);
    Route::put('/pkl', [PKLController::class, 'updateOrInsert']);
    // Route::get('/scan-irs/irs/{filename}', [IRSController::class, 'showIRS']);
});