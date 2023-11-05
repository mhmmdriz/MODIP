<?php

namespace App\Http\Controllers;

use App\Models\Skripsi;
use App\Http\Requests\StoreSkripsiRequest;
use App\Http\Requests\UpdateSkripsiRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class SkripsiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        $mahasiswa = auth()->user()->mahasiswa;
        $dataSkripsi = $mahasiswa->skripsi;

        return view('mahasiswa.skripsi.index', [
            'dataSkripsi' => $dataSkripsi,
        ]);
    }

    public function updateOrInsert(Request $request)
    {
        // dd($request->all());
        $status = $request->status;
        $mahasiswa = auth()->user()->mahasiswa;
        $nim = $mahasiswa->nim;
        $nama = $mahasiswa->nama;
        $validasi = 0;
        // dd($request->status_old);
        if ($status == ""){
            return redirect('/skripsi');
        }
        if ($request->status_old == null){
            if ($status == "Belum Ambil"){
                Skripsi::create(['nim' => $nim, 'nama' => $nama, 'status' => $status, 'validasi' => $validasi]);
            } else if ($status == "Sedang Ambil") {
                Skripsi::create(['nim' => $nim, 'nama' => $nama, 'status' => $status, 'validasi' => $validasi]);
            } else {
                $rules = [ 
                    'tanggal_sidang' => 'required',
                    'tanggal_lulus' => 'required',
                    'nilai' => 'required',
                ];
                if ($request->scan_bass_old == null) {
                    $rules['scan_bass'] = 'required|mimes:pdf|max:10000';
                }else{
                    Storage::delete($request->scan_bass_old);
                }
                
                $tgl_lulus = Carbon::parse($request->tanggal_lulus);
                $semester = ($tgl_lulus->year - $mahasiswa->angkatan) * 2 + 1;
                if ($tgl_lulus->gt(Carbon::createFromDate($tgl_lulus->year, 2, 15)) && $tgl_lulus->lte(Carbon::createFromDate($tgl_lulus->year, 8, 15))) {
                    $semester -= 1;
                } else if ($tgl_lulus->lte(Carbon::createFromDate($tgl_lulus->year, 2, 15))) {
                    $semester -= 2;
                }
                $validatedData = $request->validate($rules);
                if($request->scan_bass != null){
                    $validatedData ["scan_bass"] = $request->file('scan_bass')->store('private/skripsi');
                }
                $validatedData['semester'] = $semester;
                $validatedData['nim'] = $nim;
                $validatedData['nama'] = $nama;
                $validatedData['status'] = $status;
                $validatedData['validasi'] = $validasi;
                // dd($semester);
                Skripsi::create($validatedData);
            }
        } else {
            if ($status == "Belum Ambil"){
                Skripsi::where("nim", $nim)->update(['semester' => null, 'status' => $status, 'tanggal_sidang' => null, 'tanggal_lulus' => null, 'nilai' => null, 'scan_bass' => null]);
                if ($request->scan_bass_old != null) {
                    Storage::delete($request->scan_bass_old);
                }
            } else if ($status == "Sedang Ambil") {
                Skripsi::where("nim", $nim)->update(['semester' => null, 'status' => $status, 'tanggal_sidang' => null, 'tanggal_lulus' => null, 'nilai' => null, 'scan_bass' => null]);
                if ($request->scan_bass_old != null) {
                    Storage::delete($request->scan_bass_old);
                }
            } else {
                $rules = [ 
                    'tanggal_sidang' => 'required',
                    'tanggal_lulus' => 'required',
                    'nilai' => 'required',
                ];
                if ($request->scan_bass_old == null) {
                    $rules['scan_bass'] = 'required|mimes:pdf|max:10000';
                }else{
                    Storage::delete($request->scan_bass_old);
                }
                
                $tgl_lulus = Carbon::parse($request->tanggal_lulus);
                $semester = ($tgl_lulus->year - $mahasiswa->angkatan) * 2 + 1;
                if ($tgl_lulus->gt(Carbon::createFromDate($tgl_lulus->year, 2, 15)) && $tgl_lulus->lte(Carbon::createFromDate($tgl_lulus->year, 8, 15))) {
                    $semester -= 1;
                } else if ($tgl_lulus->lte(Carbon::createFromDate($tgl_lulus->year, 2, 15))) {
                    $semester -= 2;
                }
                $validatedData = $request->validate($rules);
                if($request->scan_bass != null){
                    $validatedData ["scan_bass"] = $request->file('scan_bass')->store('private/skripsi');
                }
                $validatedData['semester'] = $semester;
                // $validatedData['nim'] = $nim; 1
                // $validatedData['nama'] = $nama; 2
                $validatedData['status'] = $status;
                // $validatedData['validasi'] = $validasi; 3
                // dd($semester);
                Skripsi::where("nim", $nim)->update($validatedData);
            }
            
        }
        return redirect('/skripsi')->with('success', "Data Skripsi Berhasil Diubah!");
    }
}


    