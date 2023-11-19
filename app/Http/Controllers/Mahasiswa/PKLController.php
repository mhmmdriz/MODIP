<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\PKL;
use App\Http\Requests\StorePKLRequest;
use App\Http\Requests\UpdatePKLRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PKLController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() 
    {
        $mahasiswa = auth()->user()->mahasiswa;
        $dataPKL = $mahasiswa->pkl;
        $dataKHS = $mahasiswa->khs;
        $SKSk = 0;
        $n = 0;
        foreach($dataKHS as $khs){
            $SKSk += $khs->sks;
            $n++;
        }
        if ($SKSk >= 120){
            $is_eligible = True;
        } else {
            $is_eligible = False;
        }

        return view('mahasiswa.pkl.index', [
            'dataPKL' => $dataPKL,
            'is_eligible' => $is_eligible,
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
            return redirect('/pkl');
        }
        //else
        $rules = [ 
            'semester' => 'required',
            'tanggal_seminar' => 'required',
            'nilai' => 'required',
        ];
        if ($request->scan_basp_old == null) {
            $rules['scan_basp'] = 'required|mimes:pdf|max:10000';
        }else{
            Storage::delete($request->scan_basp_old);
        }
        $validatedData = $request->validate($rules);

        if ($request->status_old == null){
            $validatedData['nim'] = $nim;
            $validatedData['nama'] = $nama;
            $validatedData['status'] = $status;
            $validatedData['validasi'] = $validasi;
            if($request->scan_basp != null){
                $validatedData ["scan_basp"] = $request->file('scan_basp')->store('private/pkl');
            }
            PKL::create($validatedData);
        }
        else {
            // $validatedData['nim'] = $nim; 1
            // $validatedData['nama'] = $nama; 2
            $validatedData['status'] = $status;
            // $validatedData['validasi'] = $validasi; 3
            if($request->scan_basp != null){
                $validatedData ["scan_basp"] = $request->file('scan_basp')->store('private/pkl');
            }
            PKL::where("nim", $nim)->update($validatedData);
        }

        return redirect('/pkl')->with('success', "Data PKL Berhasil Diubah!");
    }
}

