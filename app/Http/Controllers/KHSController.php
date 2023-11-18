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
        
        // $dataKHS = $mahasiswa->getKHSArray($semester);
        // // $smtKhsArray = $dataKHS['smtKhsArray'];
        // $arrKHS = $dataKHS['arrKHS'];
        // $SKSk = $dataKHS['SKSk'];

        $arrKHS = $mahasiswa->khs;

        $SKSk = 0;
        $IPk = 0;
        $n = 0;
        foreach($arrKHS as $khs){
            $SKSk += $khs->sks;
            $IPk += $khs->ips;
            $n++;
        }
        $IPk = $IPk/$n;

        return view('mahasiswa.khs.index', [
            'khs' => $arrKHS,
            'semester' => $semester,
            // 'smtKhsArray' => $smtKhsArray,
            'SKSk' => $SKSk,
            'IPk' => $IPk,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateOrInsert(Request $request)
    {
        // dd($request->all());
        $rules = [
            'sks' => 'required',
            'sksk' => 'required',
            'ips' => 'required',
            'ipk' => 'required',
        ];

        if ($request->scan_khs_old == null) {
            $rules['scan_khs'] = 'required|mimes:pdf|max:10000';
        }else{
            Storage::delete($request->scan_khs_old);
        }

        $validatedData = $request->validate($rules);
        $mahasiswa = auth()->user()->mahasiswa;
        
        $validatedData['nama'] = $mahasiswa->nama;
        if($request->scan_khs != null){
            $validatedData ["scan_khs"] = $request->file('scan_khs')->store('private/khs');
        }

        if($request->scan_khs_old == null){
            $validatedData['smt'] = $request->smt;
            $validatedData['nim'] = $mahasiswa->nim;
            $validatedData['validasi'] = 0;
            KHS::create($validatedData);
        }else{
            KHS::where("smt", $request->smt)->where("nim",$mahasiswa->nim)->update($validatedData);
        }

        return redirect('/khs')->with('success', "Data KHS Semester $request->smt Berhasil Diubah!");
    }
}
