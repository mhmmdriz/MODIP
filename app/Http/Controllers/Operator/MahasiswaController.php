<?php

namespace App\Http\Controllers\Operator;
use App\Http\Controllers\Controller;

use App\Models\Mahasiswa;
use App\Http\Requests\UpdateMahasiswaRequest;
use Maatwebsite\Excel\Validators\ValidationException;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UserImport;
use App\Imports\MahasiswaImport;
use App\Exports\MahasiswaExport;
use App\Models\DosenWali;
use Carbon\Carbon;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_mhs = Mahasiswa::all();
        $data_angkatan = Mahasiswa::getAngkatan($data_mhs);
        $data_doswal = DosenWali::all();

        $current_year = Carbon::now()->year;
        $semua_angkatan = range($current_year, $current_year-6);

        return view("operator.akun_mhs.index", [
            "data_mhs" => $data_mhs,
            "data_angkatan" => $data_angkatan,
            "data_doswal" => $data_doswal,
            "semua_angkatan" => $semua_angkatan,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|max:255',
            'nim' => 'required|unique:mahasiswa|min:14|max:14',
            'angkatan' => 'required',
            'status' => 'required',
            'dosen_wali' => 'required',
        ]);

        Mahasiswa::create($validatedData);

        $userData = [
            'username'=> $validatedData['nim'],
            'level' => 'mahasiswa',
            'password' => Hash::make("password"),
            'status'=> 1,
        ];

        User::create($userData);

        return redirect('/akunMHS')->with('success','Akun Mahasiswa Berhasil Ditambahkan');
    }


    public function update(Request $request, Mahasiswa $akunMH){
        $rules = [
            'nama_edit' => 'required|max:255',
            'angkatan_edit' => 'required',
            'status_edit' => 'required',
            'dosen_wali_edit' => 'required',
        ];

        if($request->status_edit == "Lulus" || $request->status_edit == "DO" || $request->status_edit == "Meninggal Dunia" || $request->status_edit == "Undur Diri"){
            $rules['semester_akhir'] = 'required';
        }
        
        $validatedData = $request->validate($rules);

        $validatedData = [
            'nama' => $validatedData['nama_edit'],
            'angkatan' => $validatedData['angkatan_edit'],
            'status' => $validatedData['status_edit'],
            'dosen_wali' => $validatedData['dosen_wali_edit'],
            'semester_akhir' => $request->semester_akhir??0,
        ];

        $akunMH->update($validatedData);
        
        return redirect('/akunMHS')->with('success',"Akun Mahasiswa dengan NIM $akunMH->nim Berhasil Diubah");
    }

    public function storeImport(Request $request){
        $validatedData = $request->validate([
            'fileExcel' => 'required|mimes:xlsx,xls',
        ]);

        DB::beginTransaction();
        $import1 = new UserImport("mahasiswa");
        $import1->import(request()->file('fileExcel'));
        $import2 = new MahasiswaImport;
        $import2->import(request()->file('fileExcel'));
        
        if($import1->failures()->count() != 0 || $import2->failures()->count() != 0){
            DB::rollback();
            dd("error");
            $failures = $import1->failures()->merge($import2->failures());
            return redirect('/akunMHS')->with('error', $failures);
        } else {
            DB::commit();
            return redirect('/akunMHS')->with('success', 'Import Akun Mahasiswa Berhasil');
        }
    }

    public function exportData(Request $request){
        return (new MahasiswaExport($request->angkatanExport))->download('akun_mhs.xlsx');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mahasiswa $akunMH)
    {
        try {
            DB::beginTransaction();
            User::where('username',$akunMH->nim)->delete();
            $akunMH->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollback();
            return redirect('/akunMHS')->with('errorDelete',"Akun Mahasiswa dengan NIM $akunMH->nim Gagal Dihapus karena sudah memiliki data di tabel lain");
        }
        
        DB::commit();
        return redirect('/akunMHS')->with('success',"Akun Mahasiswa dengan NIM $akunMH->nim Berhasil Dihapus");
    }

    public function resetPassword(User $user)
    {
        $userData = [
            'password' => Hash::make("password"),
        ];

        $user->update($userData);

        return redirect('/akunMHS')->with('success', "Password Akun Mahasiswa dengan NIM $user->username Berhasil Direset");
    }

    public function updateTableMhs(Request $request){
        $data_mhs = Mahasiswa::whereRaw("nim LIKE '%$request->keyword%' OR nama LIKE '%$request->keyword%' OR angkatan LIKE '%$request->keyword%' OR status LIKE '%$request->keyword%'")->get();

        $view = view('operator.ajax.update_mhs')->with('data_mhs', $data_mhs)->render();

        return response()->json(['html' => $view]);
    }

    
    public function entryProgressIndex(){
        $data_mhs = Mahasiswa::all();
        $data_angkatan = Mahasiswa::getAngkatan($data_mhs);
        return view('operator.entry_progress_studi.index',[
            "data_mhs" => $data_mhs,
            "data_angkatan" => $data_angkatan,
        ]);
    }
}
