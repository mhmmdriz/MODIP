<?php

use App\Http\Controllers\Departemen\ProgressStudiMhs;
use App\Http\Controllers\DosenWaliController;
use App\Http\Controllers\SkripsiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IRSController;
use App\Http\Controllers\KHSController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\Login\LoginController;
use App\Http\Controllers\MahasiswaTaskController;
use App\Http\Controllers\PKLController;
use App\Http\Controllers\DosenWali\IRSController as DoswalIRSController;
use App\Http\Controllers\DosenWali\KHSController as DoswalKHSController;
use App\Http\Controllers\DosenWali\PKLController as DoswalPKLController;
use App\Http\Controllers\DosenWali\SkripsiController as DoswalSkripsiController;


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
    Route::get('/scan-skripsi/{filename}', [FileController::class, 'showSkripsi'])->where('filename', '.*');
<<<<<<< HEAD
=======
    Route::get('/scan-pkl/{filename}', [FileController::class, 'showSkripsi'])->where('filename', '.*');
>>>>>>> 06e0521f7efc51906aef9fb44169d4c134cda5c5

});

Route::middleware(['auth', 'user.role:operator'])->group(function () {
    Route::resource('/akunMHS', MahasiswaController::class);
    Route::delete('/akunMHS/{nim}', [MahasiswaController::class, 'destroy']);
    Route::get('/akunMHS/{nim}/reset', [MahasiswaController::class, 'resetPassword']);
    Route::post('/akunMHS/importExcel', [MahasiswaController::class, 'storeImport']);
    Route::post('/akunMHS/exportExcel', [MahasiswaController::class, 'exportData']);
    Route::get('/ajaxAkunMHS', [MahasiswaController::class,'updateTableMhs']);
    
    Route::resource('/akunDosenWali', DosenWaliController::class);
    Route::delete('/akunDosenWali/{nip}', [DosenWaliController::class, 'destroy']);
    Route::get('/akunDosenWali/{nip}/reset', [DosenWaliController::class, 'resetPassword']);
    Route::post('/akunDosenWali/importExcel', [DosenWaliController::class, 'storeImport']);
    Route::get('/exportAkunDosenWali', [DosenWaliController::class, 'exportData']);
    Route::get('/ajaxAkunDoswal', [DosenWaliController::class,'updateTableDoswal']);
});


Route::middleware(['auth','user.role:mahasiswa'])->group(function () {
    Route::get('/firstLogin', [MahasiswaTaskController::class,'firstLogin'])->middleware('is.datapribadiupdated');
   
    Route::put('/firstLogin', [MahasiswaTaskController::class, 'updateDataPribadi']);

    Route::get('/profile', [MahasiswaController::class, 'viewProfile']);
    Route::get('/profile/edit', [MahasiswaController::class, 'editProfile']);
    Route::put('/profile/edit', [MahasiswaController::class, 'updateProfile']);
    Route::get('/profile/edit-password', [MahasiswaController::class, 'editPassword']);
    Route::put('/profile/edit-password', [MahasiswaController::class, 'updatePassword']);
    
    Route::get('/irs', [IRSController::class, 'index']);
    Route::put('/irs', [IRSController::class, 'updateOrInsert']);
    Route::get('/khs', [KHSController::class, 'index']);
    Route::put('/khs', [KHSController::class, 'updateOrInsert']);
    Route::get('/pkl', [PKLController::class, 'index']);
    Route::put('/pkl', [PKLController::class, 'updateOrInsert']);
    Route::get('/skripsi', [SkripsiController::class, 'index']);
    Route::put('/skripsi', [SkripsiController::class, 'updateOrInsert']);
    // Route::get('/scan-irs/irs/{filename}', [IRSController::class, 'showIRS']);
});

Route::middleware(['auth', 'user.role:dosenwali'])->group(function () {
    Route::get("/irsPerwalian", [DoswalIRSController::class, 'index']);
    Route::get("/irsPerwalian/{angkatan}", [DoswalIRSController::class, 'listMhsAngkatan']);
    Route::get('/irsPerwalian/{angkatan}/{nim}', [DoswalIRSController::class, 'showIRSMhs']);
    Route::put('/irsPerwalian/{angkatan}/{nim}/update', [DoswalIRSController::class, 'updateIRSMhs']);
    Route::post("/validateIRS", [DoswalIRSController::class,"validateIRS"]);

    Route::get("/khsPerwalian", [DoswalKHSController::class, 'index']);
    Route::get("/khsPerwalian/{angkatan}", [DoswalKHSController::class, 'listMhsAngkatan']);
    Route::get('/khsPerwalian/{angkatan}/{nim}', [DoswalKHSController::class, 'showKHSMhs']);
    Route::put('/khsPerwalian/{angkatan}/{nim}/update', [DoswalKHSController::class, 'updateKHSMhs']);
    Route::post("/validateKHS", [DoswalKHSController::class,"validateKHS"]);
    
    Route::get("/pklPerwalian", [DoswalPKLController::class, 'index']);
    Route::get("/pklPerwalian/{angkatan}", [DoswalPKLController::class, 'listMhsAngkatan']);
    Route::get('/pklPerwalian/{angkatan}/{nim}', [DoswalPKLController::class, 'showPKLMhs']);
    Route::put('/pklPerwalian/{angkatan}/{nim}/update', [DoswalPKLController::class, 'updatePKLMhs']);
    Route::get("/pklPerwalian/{angkatan}/{nim}/validatePKL/{validate}", [DoswalPKLController::class,"validatePKL"]);
    
    Route::get("/skripsiPerwalian", [DoswalSkripsiController::class, 'index']);
    Route::get("/skripsiPerwalian/{angkatan}", [DoswalSkripsiController::class, 'listMhsAngkatan']);
    Route::get('/skripsiPerwalian/{angkatan}/{nim}', [DoswalSkripsiController::class, 'showSkripsiMhs']);
    Route::put('/skripsiPerwalian/{angkatan}/{nim}/update', [DoswalSkripsiController::class, 'updateSkripsiMhs']);
    Route::get("/skripsiPerwalian/{angkatan}/{nim}/validateSkripsi/{validate}", [DoswalSkripsiController::class,"validateSkripsi"]);

});

Route::middleware(['auth', 'user.role:departemen'])->group(function () {
    Route::get("/pencarianProgressStudi", [ProgressStudiMhs::class, 'index']);
    Route::get("/ajaxProgressMHS", [ProgressStudiMhs::class, 'updateTableProgressMhs']);
    Route::get("/pencarianProgressStudi/{nim}", [ProgressStudiMhs::class, 'showProgressMhs']);
});