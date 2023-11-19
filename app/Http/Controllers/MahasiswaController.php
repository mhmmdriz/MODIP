<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Http\Requests\UpdateMahasiswaRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UserImport;
use App\Imports\MahasiswaImport;
use App\Exports\MahasiswaExport;
use App\Models\DosenWali;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_mhs = Mahasiswa::all();
        $data_angkatan = $data_mhs->pluck('angkatan')->unique()->values();
        $data_doswal = DosenWali::all();

        return view("operator.akun_mhs.index", [
            "data_mhs" => $data_mhs,
            "data_angkatan" => $data_angkatan,
            "data_doswal" => $data_doswal,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd();
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
        // dd($akunMH);
        $rules = [
            'nama_edit' => 'required|max:255',
            'angkatan_edit' => 'required',
            'status_edit' => 'required',
            'dosen_wali_edit' => 'required',
        ];

        // if($request->nim_edit != $akunMH->nim){
        //     $rules['nim_edit'] = 'required|unique:mahasiswa,nim|min:14|max:14';
        // }
        
        $validatedData = $request->validate($rules);

        $validatedData = [
            'nama' => $validatedData['nama_edit'],
            // 'nim' => $validatedData['nim_edit'],
            'angkatan' => $validatedData['angkatan_edit'],
            'status' => $validatedData['status_edit'],
            'dosen_wali' => $validatedData['dosen_wali_edit'],
        ];

        Mahasiswa::where('nim', $akunMH->nim)->update($validatedData);

        return redirect('/akunMHS')->with('success',"Akun Mahasiswa dengan NIM $akunMH->nim Berhasil Diubah");
    }

    public function storeImport(Request $request){
        $validatedData = $request->validate([
            'fileExcel' => 'required',
        ]);

        Excel::import(new UserImport("mahasiswa"), request()->file('fileExcel'));
        Excel::import(new MahasiswaImport, request()->file('fileExcel'));

        return redirect('/akunMHS')->with('success','Import Akun Mahasiswa Berhasil');
    }

    public function exportData(Request $request){
        return (new MahasiswaExport($request->angkatanExport))->download('akun_mhs.xlsx');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $nim)
    {
        User::where('username',$nim)->delete();
        
        Mahasiswa::where('nim',$nim)->delete();

        return redirect('/akunMHS')->with('success',"Akun Mahasiswa dengan NIM $nim Berhasil Dihapus");
    }

    public function resetPassword(String $nim)
    {
        $userData = [
            'password' => Hash::make("password"),
        ];

        User::where('username', $nim)->update($userData);

        return redirect('/akunMHS')->with('success', "Password Akun Mahasiswa dengan NIM $nim Berhasil Direset");
    }

    public function updateTableMhs(Request $request){
        $data_mhs = Mahasiswa::whereRaw("nim LIKE '%$request->keyword%' OR nama LIKE '%$request->keyword%' OR angkatan LIKE '%$request->keyword%' OR status LIKE '%$request->keyword%'")->get();

        $view = view('operator.ajax.update_mhs')->with('data_mhs', $data_mhs)->render();

        return response()->json(['html' => $view]);
    }

}
