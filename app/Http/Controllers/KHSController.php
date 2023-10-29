<?php

namespace App\Http\Controllers;

use App\Models\KHS;
use App\Http\Requests\StoreKHSRequest;
use App\Http\Requests\UpdateKHSRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class KHSController extends Controller
{
    public function index()
    {
        $mahasiswa = auth()->user()->mahasiswa;
        $semesterInfo = $mahasiswa->calculateSemesterAndThnAjar();
        $semester = $semesterInfo['semester'];
        
        $dataKHS = $mahasiswa->getKHSArray($semester);
        $smtIrsArray = $dataKHS['smtIrsArray'];
        $arrIRS = $dataKHS['arrIRS'];
        $SKSk = $dataKHS['SKSk'];

        // dump($SKSk);
        // dump($smtIrsArray);
        // dd($arrIRS);

        return view('mahasiswa.irs.index', [
            'irs' => $arrIRS,
            'semester' => $semester,
            'smtIrsArray' => $smtIrsArray,
            'SKSk' => $SKSk,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateOrInsert(Request $request)
    {
        $rules = [
            'sks' => 'required',
        ];

        if ($request->scan_irs_old == null) {
            $rules['scan_irs'] = 'required|mimes:pdf|max:10000';
        }else{
            Storage::delete("private/".$request->scan_irs_old);
        }

        $validatedData = $request->validate($rules);
        $mahasiswa = auth()->user()->mahasiswa;
        
        $validatedData['nama'] = $mahasiswa->nama;
        if($request->scan_irs != null){
            $validatedData ["scan_irs"] = $request->file('scan_irs')->store('private/irs');
        }

        if($request->scan_irs_old == null){
            $validatedData['smt'] = $request->smt;
            $validatedData['nim'] = $mahasiswa->nim;
            $validatedData['validasi'] = 0;
            KHS::create($validatedData);
        }else{
            KHS::where("smt", $request->smt)->where("nim",$mahasiswa->nim)->update($validatedData);
        }

        return redirect('/irs')->with('success', "Data IRS Semester $request->smt Berhasil Diubah!");
    }
}
