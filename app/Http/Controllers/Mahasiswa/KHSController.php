<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\KHS;
use Illuminate\Http\Request;

class KHSController extends Controller
{
    public function index()
    {
        $mahasiswa = auth()->user()->mahasiswa;
        $semesterInfo = $mahasiswa->calculateSemesterAndThnAjar();
        $semester = $semesterInfo['semester'];

        $arrKHS = $mahasiswa->khs;
        $arrIRS = $mahasiswa->irs;

        $dataKHS = KHS::rekapKHS($arrKHS);

        return view('mahasiswa.khs.index', [
            'khs' => $arrKHS,
            'irs' => $arrIRS,
            'semester' => $semester,
            'SKSk' => $dataKHS['SKSk'],
            'IPk' => $dataKHS['IPk'],
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
        }

        $validatedData = $request->validate($rules);

        KHS::updateOrInsert($request, $validatedData);

        return redirect('/khs')->with('success', "Data KHS Semester $request->smt Berhasil Diubah!");
    }
}
