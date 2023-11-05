<?php

namespace App\Http\Controllers;

use App\Models\Skripsi;
use App\Http\Requests\StoreSkripsiRequest;
use App\Http\Requests\UpdateSkripsiRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SkripsiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        $mahasiswa = auth()->user()->mahasiswa;
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
        ]);
    }

    public function updateOrInsert(Request $request)
    {
        // dd($request->all());
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

        return redirect('/skripsi')->with('success', "Data Skripsi Berhasil Diubah!");
    }
}


    