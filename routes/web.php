<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\Operator\DosenWaliController;
use App\Http\Controllers\Operator\DepartemenController;
use App\Http\Controllers\Operator\MahasiswaController;
// use App\Http\Controllers\Operator\IRSController as OperatorIRSController;

use App\Http\Controllers\Mahasiswa\MahasiswaTaskController;

use App\Http\Controllers\OpMhs\IRSController;
use App\Http\Controllers\OpMhs\KHSController;
use App\Http\Controllers\OpMhs\SkripsiController;
use App\Http\Controllers\OpMhs\PKLController;

use App\Http\Controllers\OpDos\IRSController as IRSValidationController;
use App\Http\Controllers\OpDos\KHSController as KHSValidationController;
use App\Http\Controllers\OpDos\PKLController as PKLValidationController;
use App\Http\Controllers\OpDos\SkripsiController as SkripsiValidationController;

use App\Http\Controllers\OpDepDos\ProgressStudiMhs;
use App\Http\Controllers\OpDepDos\RekapListPKLController;
use App\Http\Controllers\OpDepDos\RekapListSkripsiController;
use App\Http\Controllers\OpDepDos\RekapListStatusController;


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
    Route::get('/akunDosenWali/{user}/reset', [DosenWaliController::class, 'resetPassword']);
    Route::post('/akunDosenWali/importExcel', [DosenWaliController::class, 'storeImport']);
    Route::get('/exportAkunDosenWali', [DosenWaliController::class, 'exportData']);
    Route::get('/ajaxAkunDoswal', [DosenWaliController::class,'updateTableDoswal']);

    Route::resource('/akunDepartemen', DepartemenController::class);
    Route::get('/akunDepartemen/{user}/reset', [DepartemenController::class, 'resetPassword']);

    Route::get('/validasiProgress', fn() => view('operator.validasi_progress_studi.index'));

    Route::get("/validasiProgress/validasiIRS", [IRSValidationController::class, 'index']);
    Route::get("/validasiProgress/validasiIRS/{angkatan}", [IRSValidationController::class, 'listMhsAngkatan']);
    Route::get('/validasiProgress/validasiIRS/{angkatan}/{mahasiswa}', [IRSValidationController::class, 'showIRSMhs']);
    Route::put('/validasiProgress/validasiIRS/{angkatan}/{mahasiswa}/update', [IRSValidationController::class, 'updateIRSMhs']);
    // Route::post("/validasiProgress/validasiIRS/validate", [IRSValidationController::class,"validateIRS"]);

    Route::get('/rekapMhs', fn() => view('operator.rekap_mhs.index'));
    Route::get("/rekapMhs/rekapPKL", [RekapListPKLController::class,"rekap"]);
    Route::get("/rekapMhs/rekapSkripsi", [RekapListSkripsiController::class,"rekap"]);
    Route::get("/rekapMhs/rekapStatus", [RekapListStatusController::class,"rekap"]);

    Route::get('/entryProgress', fn() => view('operator.entry_progress_studi.index'));


    Route::get('/download-file/{filename}', [FileController::class, 'downloadFile'])->where('filename', '.*');
});

Route::middleware(['auth', 'user.role:mahasiswa,operator'])->group(function () {
    Route::get('/irs', [IRSController::class, 'index']);
    Route::put('/irs', [IRSController::class, 'updateOrInsert']);
    Route::get('/khs', [KHSController::class, 'index']);
    Route::put('/khs', [KHSController::class, 'updateOrInsert']);
    Route::get('/pkl', [PKLController::class, 'index']);
    Route::put('/pkl', [PKLController::class, 'updateOrInsert']);
    Route::get('/skripsi', [SkripsiController::class, 'index']);
    Route::put('/skripsi', [SkripsiController::class, 'updateOrInsert']);
    
});

Route::middleware(['auth','user.role:mahasiswa'])->group(function () {
    Route::get('/firstLogin', [MahasiswaTaskController::class,'firstLogin'])->middleware('is.datapribadiupdated');
    Route::put('/firstLogin', [MahasiswaTaskController::class, 'updateDataPribadi']);
    
});

Route::middleware(['auth', 'user.role:dosenwali'])->group(function () {

    Route::get("/pencarianProgressStudiPerwalian", [ProgressStudiMhs::class, 'index']);
    Route::get("/ajaxProgressMHSPerwalian", [ProgressStudiMhs::class, 'updateTableProgressMhs']);
    Route::get("/pencarianProgressStudiPerwalian/{mahasiswa}", [ProgressStudiMhs::class, 'showProgressMhs']);

    Route::get("/irsPerwalian", [IRSValidationController::class, 'index']);
    Route::get("/irsPerwalian/{angkatan}", [IRSValidationController::class, 'listMhsAngkatan']);
    Route::get('/irsPerwalian/{angkatan}/{mahasiswa}', [IRSValidationController::class, 'showIRSMhs']);
    Route::put('/irsPerwalian/{angkatan}/{mahasiswa}/update', [IRSValidationController::class, 'updateIRSMhs']);
    

    Route::get("/khsPerwalian", [KHSValidationController::class, 'index']);
    Route::get("/khsPerwalian/{angkatan}", [KHSValidationController::class, 'listMhsAngkatan']);
    Route::get('/khsPerwalian/{angkatan}/{mahasiswa}', [KHSValidationController::class, 'showKHSMhs']);
    Route::put('/khsPerwalian/{angkatan}/{mahasiswa}/update', [KHSValidationController::class, 'updateKHSMhs']);
    Route::post("/validateKHS", [KHSValidationController::class,"validateKHS"]);
    
    Route::get("/pklPerwalian", [PKLValidationController::class, 'index']);
    Route::get("/pklPerwalian/{angkatan}", [PKLValidationController::class, 'listMhsAngkatan']);
    Route::get('/pklPerwalian/{angkatan}/{nim}', [PKLValidationController::class, 'showPKLMhs']);
    Route::put('/pklPerwalian/{angkatan}/{nim}/update', [PKLValidationController::class, 'updatePKLMhs']);
    Route::get("/pklPerwalian/{angkatan}/{nim}/validatePKL/{validate}", [PKLValidationController::class,"validatePKL"]);
    
    Route::get("/skripsiPerwalian", [SkripsiValidationController::class, 'index']);
    Route::get("/skripsiPerwalian/{angkatan}", [SkripsiValidationController::class, 'listMhsAngkatan']);
    Route::get('/skripsiPerwalian/{angkatan}/{nim}', [SkripsiValidationController::class, 'showSkripsiMhs']);
    Route::put('/skripsiPerwalian/{angkatan}/{nim}/update', [SkripsiValidationController::class, 'updateSkripsiMhs']);
    Route::get("/skripsiPerwalian/{angkatan}/{nim}/validateSkripsi/{validate}", [SkripsiValidationController::class,"validateSkripsi"]);

    Route::get('/rekapMhsPerwalian', fn() => view('dosenwali.rekap_mhs.index'));
    Route::get("/rekapMhsPerwalian/rekapPKL", [RekapListPKLController::class,"rekap"]);
    Route::get("/rekapMhsPerwalian/rekapSkripsi", [RekapListSkripsiController::class,"rekap"]);
    Route::get("/rekapMhsPerwalian/rekapStatus", [RekapListStatusController::class,"rekap"]);
});

Route::middleware(['auth', 'user.role:dosenwali,operator'])->group(function () {
    Route::post("/validateIRS", [IRSValidationController::class,"validateIRS"]);
});


Route::middleware(['auth', 'user.role:departemen'])->group(function () {
    Route::get("/rekapPKL", [RekapListPKLController::class,"rekap"]);
    Route::get("/rekapSkripsi", [RekapListSkripsiController::class,"rekap"]);
    Route::get("/rekapStatus", [RekapListStatusController::class,"rekap"]);
});

Route::middleware(['auth', 'user.role:departemen,dosenwali,operator'])->group(function () {
    Route::get("/pencarianProgressStudi", [ProgressStudiMhs::class, 'index']);
    Route::get("/ajaxProgressMHS", [ProgressStudiMhs::class, 'updateTableProgressMhs']);
    Route::get("/pencarianProgressStudi/{mahasiswa}", [ProgressStudiMhs::class, 'showProgressMhs']);

    Route::get("/showListMhsPKL", [RekapListPKLController::class, "showList"]);
    Route::post("/printListMhsPKL", [RekapListPKLController::class, "printList"]);
    Route::post("/printRekapPKL", [RekapListPKLController::class, "printRekap"]);
    
    Route::get("/showListMhsSkripsi", [RekapListSkripsiController::class, "showList"]);
    Route::post("/printListMhsSkripsi", [RekapListSkripsiController::class, "printList"]);
    Route::post("/printRekapSkripsi", [RekapListSkripsiController::class, "printRekap"]);
    
    Route::post("/printListMhsStatus", [RekapListStatusController::class, "printList"]);
    Route::post("/printRekapStatus", [RekapListStatusController::class, "printRekap"]);
    Route::get("/showListStatusAjax", [RekapListStatusController::class, "showListAjax"]);
});