<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\IRS;
use App\Http\Requests\StoreIRSRequest;
use App\Http\Requests\UpdateIRSRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;


class IRSController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mahasiswa = auth()->user()->mahasiswa;
        $semesterInfo = $mahasiswa->calculateSemesterAndThnAjar();
        $semester = $semesterInfo['semester'];
        
        // $dataIRS = $mahasiswa->getIRSArray($semester);
        // $smtIRSArray = $dataIRS['smtIRSArray'];
        // $arrIRS = $dataIRS['arrIRS'];
        // $SKSk = $dataIRS['SKSk'];

        $arrIRS = $mahasiswa->irs;

        $SKSk = 0;
        foreach($arrIRS as $irs){
            $SKSk += $irs->sks;
        }


        // dump($SKSk);
        // // dump($smtIRSArray);
        // dd($arrIRS);

        return view('mahasiswa.irs.index', [
            'irs' => $arrIRS,
            'semester' => $semester,
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
            Storage::delete($request->scan_irs_old);
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
            IRS::create($validatedData);
        }else{
            IRS::where("smt", $request->smt)->where("nim",$mahasiswa->nim)->update($validatedData);
        }

        

        return redirect('/irs')->with('success', "Data IRS Semester $request->smt Berhasil Diubah!");
    }
}
