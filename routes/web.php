<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\Operator\DosenWaliController;
use App\Http\Controllers\Operator\DepartemenController;
use App\Http\Controllers\Operator\MahasiswaController;

use App\Http\Controllers\Mahasiswa\IRSController;
use App\Http\Controllers\Mahasiswa\KHSController;
use App\Http\Controllers\Mahasiswa\SkripsiController;
use App\Http\Controllers\Mahasiswa\MahasiswaTaskController;
use App\Http\Controllers\Mahasiswa\PKLController;

use App\Http\Controllers\DosenWali\IRSController as DoswalIRSController;
use App\Http\Controllers\DosenWali\KHSController as DoswalKHSController;
use App\Http\Controllers\DosenWali\PKLController as DoswalPKLController;
use App\Http\Controllers\DosenWali\SkripsiController as DoswalSkripsiController;
use App\Http\Controllers\DosenWali\ProgressStudiMhs as DoswalProgressStudiMhs;

use App\Http\Controllers\Departemen\ProgressStudiMhs;
use App\Http\Controllers\Departemen\RekapListPKLController;
use App\Http\Controllers\Departemen\RekapListSkripsiController;
use App\Http\Controllers\Departemen\RekapListStatusController;


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
    Route::get('/profile', [ProfileController::class,'viewProfile']);
    Route::get('/profile/edit', [ProfileController::class, 'editProfile']);
    Route::put('/profile/edit', [ProfileController::class, 'updateProfile']);
    Route::get('/profile/edit-password', [ProfileController::class, 'editPassword']);
    Route::put('/profile/edit-password', [ProfileController::class, 'updatePassword']);

    Route::post('/logout', [LoginController::class, 'logout']);

    Route::get('/photo/{photoname}', [FileController::class, 'showProfilePhoto'])->where('photoname', '.*');
    Route::get('/scan-irs/{filename}', [FileController::class, 'showIRS'])->where('filename', '.*');
    Route::get('/scan-khs/{filename}', [FileController::class, 'showKHS'])->where('filename', '.*');
    Route::get('/scan-skripsi/{filename}', [FileController::class, 'showSkripsi'])->where('filename', '.*');
    Route::get('/scan-pkl/{filename}', [FileController::class, 'showSkripsi'])->where('filename', '.*');
    Route::get('/template/{filename}', [FileController::class, 'template'])->where('filename', '.*');
    Route::get('/showFile/{filename}', [FileController::class, 'showFile'])->where('filename', '.*');
});

Route::middleware(['auth', 'user.role:operator'])->group(function () {

    Route::resource('/akunMHS', MahasiswaController::class);
    Route::get('/akunMHS/{user}/reset', [MahasiswaController::class, 'resetPassword']);
    Route::post('/akunMHS/importExcel', [MahasiswaController::class, 'storeImport']);
    Route::post('/akunMHS/exportExcel', [MahasiswaController::class, 'exportData']);
    Route::get('/ajaxAkunMHS', [MahasiswaController::class,'updateTableMhs']);
    
    Route::resource('/akunDosenWali', DosenWaliController::class);
    Route::delete('/akunDosenWali/{nip}', [DosenWaliController::class, 'destroy']);
    Route::get('/akunDosenWali/{nip}/reset', [DosenWaliController::class, 'resetPassword']);
    Route::post('/akunDosenWali/importExcel', [DosenWaliController::class, 'storeImport']);
    Route::get('/exportAkunDosenWali', [DosenWaliController::class, 'exportData']);
    Route::get('/ajaxAkunDoswal', [DosenWaliController::class,'updateTableDoswal']);

    Route::resource('/akunDepartemen', DepartemenController::class);
    Route::delete('/akunDepartemen/{nip}', [DepartemenController::class, 'destroy']);
    Route::get('/akunDepartemen/{nip}/reset', [DepartemenController::class, 'resetPassword']);

    Route::get('/download-file/{filename}', [FileController::class, 'downloadFile'])->where('filename', '.*');
});


Route::middleware(['auth','user.role:mahasiswa'])->group(function () {
    Route::get('/firstLogin', [MahasiswaTaskController::class,'firstLogin'])->middleware('is.datapribadiupdated');
   
    Route::put('/firstLogin', [MahasiswaTaskController::class, 'updateDataPribadi']);
    
    Route::get('/irs', [IRSController::class, 'index']);
    Route::put('/irs', [IRSController::class, 'updateOrInsert']);
    Route::get('/khs', [KHSController::class, 'index']);
    Route::put('/khs', [KHSController::class, 'updateOrInsert']);
    Route::get('/pkl', [PKLController::class, 'index']);
    Route::put('/pkl', [PKLController::class, 'updateOrInsert']);
    Route::get('/skripsi', [SkripsiController::class, 'index']);
    Route::put('/skripsi', [SkripsiController::class, 'updateOrInsert']);
});

Route::middleware(['auth', 'user.role:dosenwali'])->group(function () {

    Route::get("/pencarianProgressStudiPerwalian", [DoswalProgressStudiMhs::class, 'index']);
    Route::get("/ajaxProgressMHSPerwalian", [DoswalProgressStudiMhs::class, 'updateTableProgressMhs']);
    Route::get("/pencarianProgressStudiPerwalian/{nim}", [DoswalProgressStudiMhs::class, 'showProgressMhs']);

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

    Route::get("/rekapPKL", [RekapListPKLController::class,"rekap"]);
    Route::get("/showListMhsPKL", [RekapListPKLController::class, "showList"]);
    Route::post("/printListMhsPKL", [RekapListPKLController::class, "printList"]);
    Route::post("/printRekapPKL", [RekapListPKLController::class, "printRekap"]);
    
    Route::get("/rekapSkripsi", [RekapListSkripsiController::class,"rekap"]);
    Route::get("/showListMhsSkripsi", [RekapListSkripsiController::class, "showList"]);
    Route::post("/printListMhsSkripsi", [RekapListSkripsiController::class, "printList"]);
    Route::post("/printRekapSkripsi", [RekapListSkripsiController::class, "printRekap"]);
    
    Route::get("/rekapStatus", [RekapListStatusController::class,"rekap"]);
    // Route::get("/showListMhsStatus/{angkatan}", [RekapListStatusController::class, "showList"]);
    Route::get("/showListMhsStatus/{angkatan}/{status?}", [RekapListStatusController::class, "showList"]);
    Route::post("/printListMhsStatus", [RekapListStatusController::class, "printList"]);
    Route::post("/printRekapStatus", [RekapListStatusController::class, "printRekap"]);
    Route::get("/showListStatusAjax", [RekapListStatusController::class, "showListAjax"]);
});