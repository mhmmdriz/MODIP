<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Login\LoginController;
use App\Http\Controllers\MahasiswaController;

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
    Route::get('/dashboard', [LoginController::class,'dashboard']);

    Route::post('/logout', [LoginController::class, 'logout']);

    Route::get('/dosen', [LoginController::class, 'dosen'])->middleware('user.role:dosenwali');
    
});

Route::middleware(['auth', 'user.role:operator'])->group(function () {
    Route::resource('/akunMHS', MahasiswaController::class);
    
    Route::delete('/akunMHS/{nim}', [MahasiswaController::class, 'destroy']);
    Route::post('/akunMHS/importExcel', [MahasiswaController::class, 'storeImport']);
    Route::post('/akunMHS/exportExcel', [MahasiswaController::class, 'exportData']);
    Route::get('/ajaxAkunMHS', [MahasiswaController::class,'updateTableMhs']);
});