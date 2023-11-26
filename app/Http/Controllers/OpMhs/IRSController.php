<?php

namespace App\Http\Controllers\OpMhs;

use App\Http\Controllers\Controller;
use App\Models\IRS;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class IRSController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Mahasiswa $mahasiswa)
    {
        if (auth()->user()->level == "mahasiswa") {
            $mahasiswa = auth()->user()->mahasiswa;
        }
        $semesterInfo = $mahasiswa->calculateSemesterAndThnAjar();
        $semester = $semesterInfo['semester'];

        $arrIRS = $mahasiswa->irs;

        $SKSk = 0;
        foreach($arrIRS as $irs){
            $SKSk += $irs->sks;
        }

        return view('mahasiswa.irs.index', [
            'mahasiswa' => $mahasiswa,
            'irs' => $arrIRS,
            'semester' => $semester,
            'SKSk' => $SKSk,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateOrInsert(Mahasiswa $mahasiswa, Request $request)
    {
        $rules = [
            'sks' => 'required',
        ];

        if ($request->scan_irs_old == null) {
            $rules['scan_irs'] = 'required|mimes:pdf|max:10000';
        }

        $validatedData = $request->validate($rules);

        IRS::updateOrInsert($mahasiswa, $request, $validatedData);

        if (auth()->user()->level == "mahasiswa") {
            return redirect('/irs')->with('success', "Data IRS Semester $request->smt Berhasil Diubah!");
        } else {
            return redirect('/entryProgress/entryIRS/' . $mahasiswa->nim)->with('success', "Data IRS Semester $request->smt Berhasil Diubah!");
        }
    }
}
