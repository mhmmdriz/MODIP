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

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_mhs = Mahasiswa::all();

        return view("operator.akun_mhs.index", [
            "data_mhs" => $data_mhs,
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mahasiswa $mahasiswa)
    {
        //
    }

    public function updateTableMhs(Request $request){
        $data_mhs = Mahasiswa::whereRaw("nim LIKE '%$request->keyword%' OR nama LIKE '%$request->keyword%'")->get();

        $view = view('operator.ajax.update_mhs')->with('data_mhs', $data_mhs)->render();

        return response()->json(['html' => $view]);
    }
}
