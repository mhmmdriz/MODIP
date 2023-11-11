<?php

namespace App\Http\Controllers;

use App\Models\Skripsi;
use App\Http\Requests\StoreSkripsiRequest;
use App\Http\Requests\UpdateSkripsiRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
<<<<<<< HEAD
=======
use Carbon\Carbon;
>>>>>>> 06e0521f7efc51906aef9fb44169d4c134cda5c5

class SkripsiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        $mahasiswa = auth()->user()->mahasiswa;
<<<<<<< HEAD
        $semesterInfo = $mahasiswa->calculateSemesterAndThnAjar();
        $semester = $semesterInfo['semester'];
        
        $dataKHS = $mahasiswa->getKHSArray($semester);
        // $smtKhsArray = $dataKHS['smtKhsArray'];
        $SKSk = $dataKHS['SKSk'];

        // dump($SKSk);
        // dump($smtKhsArray);
        // dd($arrKHS);

        return view('mahasiswa.skripsi.index', [
            'semester' => $semester,
            // 'smtKhsArray' => $smtKhsArray,
            'SKSk' => $SKSk,
=======
        $dataSkripsi = $mahasiswa->skripsi;

        return view('mahasiswa.skripsi.index', [
            'dataSkripsi' => $dataSkripsi,
>>>>>>> 06e0521f7efc51906aef9fb44169d4c134cda5c5
        ]);
    }

    public function updateOrInsert(Request $request)
    {
        // dd($request->all());
<<<<<<< HEAD
        $rules = [ 
            'status' => 'required',
            'tanggal' => 'required',
            'nilai' => 'required',
        ];

        if ($request->scan_bass_old == null) {
            $rules['scan_bass'] = 'required|mimes:pdf|max:10000';
        }else{
            Storage::delete($request->scan_bass_old);
        }

        $validatedData = $request->validate($rules);
        $mahasiswa = auth()->user()->mahasiswa;
        
        $validatedData['nama'] = $mahasiswa->nama;
        if($request->scan_bass != null){
            $validatedData ["scan_bass"] = $request->file('scan_bass')->store('private/skripsi');
        }

        if($request->scan_bass_old == null){
            $validatedData[''] = $request->smt;
            $validatedData['nim'] = $mahasiswa->nim;
            $validatedData['validasi'] = 0;
            Skripsi::create($validatedData);
        }else{
            Skripsi::where("smt", $request->smt)->where("nim",$mahasiswa->nim)->update($validatedData);
        }

=======
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
>>>>>>> 06e0521f7efc51906aef9fb44169d4c134cda5c5
        return redirect('/skripsi')->with('success', "Data Skripsi Berhasil Diubah!");
    }
}


    