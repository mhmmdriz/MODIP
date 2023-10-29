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
use App\Exports\UsersExport;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_mhs = Mahasiswa::all();
        $data_angkatan = $data_mhs->pluck('angkatan')->unique()->values();

        return view("operator.akun_mhs.index", [
            "data_mhs" => $data_mhs,
            "data_angkatan" => $data_angkatan
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|max:255',
            'nim' => 'required|min:14|max:14',
            'angkatan' => 'required',
            'status' => 'required',
        ]);

        Mahasiswa::create($validatedData);

        $userData = [
            'username'=> $validatedData['nim'],
            'level' => 'mahasiswa',
            'password' => Hash::make("password"),
            'status'=> 'aktif',
        ];

        User::create($userData);

        return redirect('/akunMHS');
    }

    public function storeImport(Request $request){
        $validatedData = $request->validate([
            'fileExcel' => 'required',
        ]);

        Excel::import(new UserImport, request()->file('fileExcel'));
        Excel::import(new MahasiswaImport, request()->file('fileExcel'));

        return redirect('/akunMHS');
    }

    /**
     * Display the specified resource.
     */
    public function show(Mahasiswa $mahasiswa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mahasiswa $mahasiswa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMahasiswaRequest $request, Mahasiswa $mahasiswa)
    {
        //
    }


    public function exportData(Request $request){
        return (new UsersExport($request->angkatanExport))->download('akun_mhs.xlsx');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $nim)
    {
        Mahasiswa::where('nim',$nim)->delete();

        User::where('username',$nim)->delete();

        return redirect('/akunMHS')->with('success','Akun Mahasiswa Berhasil Dihapus');
    }

    public function updateTableMhs(Request $request){
        $data_mhs = Mahasiswa::whereRaw("nim LIKE '%$request->keyword%' OR nama LIKE '%$request->keyword%' OR angkatan LIKE '%$request->keyword%' OR status LIKE '%$request->keyword%'")->get();

        $view = view('operator.ajax.update_mhs')->with('data_mhs', $data_mhs)->render();

        return response()->json(['html' => $view]);
    }

    public function viewProfile(){
        return view('mahasiswa.profile.index');
    }

    public function editProfile(){
        return view('mahasiswa.profile.edit');
    }

    public function updateProfile(Request $request){
        $rules = [
            'no_telp' => 'required|numeric',
            'email_sso' => 'required',
            'alamat' => 'required',
            'kabupaten_kota' => 'required',
            'provinsi' => 'required',
        ];
        
        $validatedData = $request->validate($rules);

        Mahasiswa::where('nim', auth()->user()->mahasiswa->nim)->update($validatedData);

        return redirect('/profile');
    }
}
