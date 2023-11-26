<?php

namespace App\Http\Controllers\OpMhs;

use App\Http\Controllers\Controller;
use App\Models\Skripsi;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class SkripsiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Mahasiswa $mahasiswa)
    {
        if (auth()->user()->level == "mahasiswa") {
            $mahasiswa = auth()->user()->mahasiswa;
        }
       
        $dataSkripsi = $mahasiswa->skripsi;
        $dataKHS = $mahasiswa->khs;
        $is_eligible = Skripsi::isEligible($dataKHS);

        return view('mahasiswa.skripsi.index', [
            'mahasiswa' => $mahasiswa,
            'dataSkripsi' => $dataSkripsi,
            'is_eligible' => $is_eligible,
        ]);
    }

    public function updateOrInsert(Mahasiswa $mahasiswa, Request $request)
    {
        $rules = [ 
            'semester' => 'required',
            'tanggal_sidang' => 'required',
            'nilai' => 'required',
        ];
        if ($request->scan_bass_old == null) {
            $rules['scan_bass'] = 'required|mimes:pdf|max:10000';
        }
        $validatedData = $request->validate($rules);

        Skripsi::updateOrInsert($mahasiswa, $request, $validatedData);

        if (auth()->user()->level == "mahasiswa") {
            return redirect('/skripsi')->with('success', "Data Skripsi Berhasil Diubah!");
        } else {
            return redirect('/entryProgress/entrySkripsi/' . $mahasiswa->nim)->with('success', "Data Skripsi Berhasil Diubah!");
        }
     }
}
