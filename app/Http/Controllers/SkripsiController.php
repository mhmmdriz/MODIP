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
       
        $dataSkripsi = $mahasiswa->skripsi;

        return view('mahasiswa.skripsi.index', [
            'dataSkripsi' => $dataSkripsi,

        ]);
    }

    public function updateOrInsert(Request $request)
    {
        $status = $request->status;
        $mahasiswa = auth()->user()->mahasiswa;
        $nim = $mahasiswa->nim;
        $nama = $mahasiswa->nama;
        $validasi = 0;
        // dd($request->status_old);
        if ($status == ""){
            return redirect('/skripsi');
        }
        //else
        $rules = [ 
            'semester' => 'required',
            'tanggal_sidang' => 'required',
            'nilai' => 'required',
        ];
        if ($request->scan_bass_old == null) {
            $rules['scan_bass'] = 'required|mimes:pdf|max:10000';
        }else{
            Storage::delete($request->scan_bass_old);
        }
        $validatedData = $request->validate($rules);

        if ($request->status_old == null){
            $validatedData['nim'] = $nim;
            $validatedData['nama'] = $nama;
            $validatedData['status'] = $status;
            $validatedData['validasi'] = $validasi;
            if($request->scan_bass != null){
                $validatedData ["scan_bass"] = $request->file('scan_bass')->store('private/skripsi');
            }
            Skripsi::create($validatedData);
        }
        else {
            // $validatedData['nim'] = $nim; 1
            // $validatedData['nama'] = $nama; 2
            $validatedData['status'] = $status;
            // $validatedData['validasi'] = $validasi; 3
            if($request->scan_bass != null){
                $validatedData ["scan_bass"] = $request->file('scan_bass')->store('private/skripsi');
            }
            Skripsi::where("nim", $nim)->update($validatedData);
        }

        return redirect('/skripsi')->with('success', "Data Skripsi Berhasil Diubah!");
     }
}
