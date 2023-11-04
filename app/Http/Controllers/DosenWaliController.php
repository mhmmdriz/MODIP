<?php

namespace App\Http\Controllers;

use App\Exports\DosenWaliExport;
use App\Imports\DosenWaliImport;
use App\Imports\UserImport;
use App\Models\User;
use App\Models\DosenWali;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DosenWaliController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_doswal = DosenWali::all();

        return view("operator.akun_doswal.index", [
            "data_doswal" => $data_doswal,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|max:255',
            'nip' => 'required|unique:dosen_wali|min:14|max:14',
            'no_telp' => 'required',
            'email_sso' => 'required|unique:dosen_wali|regex:/^[a-zA-Z]+@lecturers\.undip\.ac\.id$/',
        ]);

        DosenWali::create($validatedData);

        $userData = [
            'username'=> $validatedData['nip'],
            'level' => 'dosenwali',
            'password' => Hash::make("password"),
            'status'=> 1,
        ];

        User::create($userData);

        return redirect('/akunDosenWali')->with('success','Akun Dosen Wali Berhasil Ditambahkan');
    }

    public function storeImport(Request $request){
        $validatedData = $request->validate([
            'fileExcel' => 'required',
        ]);

        Excel::import(new UserImport("dosenwali"), request()->file('fileExcel'));
        Excel::import(new DosenWaliImport, request()->file('fileExcel'));

        return redirect('/akunDosenWali')->with('success','Import Akun Mahasiswa Berhasil');
    }

    public function exportData(){
        return (new DosenWaliExport)->download('akun_doswal.xlsx');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $nip)
    {
        DosenWali::where('nip', $nip)->delete();
        User::where('username', $nip)->delete();

        return redirect('/akunDosenWali')->with('success',"Akun Dosen Wali dengan NIP $nip Berhasil Dihapus");
    }

    public function resetPassword(String $nip)
    {
        $userData = [
            'password' => Hash::make("password"),
        ];

        User::where('username', $nip)->update($userData);

        return redirect('/akunDosenWali')->with('success', "Password Akun Dosen Wali dengan NIP $nip Berhasil Direset");
    }
}
