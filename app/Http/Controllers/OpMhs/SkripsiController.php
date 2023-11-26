<?php

namespace App\Http\Controllers\OpMhs;

use App\Http\Controllers\Controller;
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
        $dataKHS = $mahasiswa->khs;
        $is_eligible = Skripsi::isEligible($dataKHS);

        return view('mahasiswa.skripsi.index', [
            'dataSkripsi' => $dataSkripsi,
            'is_eligible' => $is_eligible,
        ]);
    }

    public function updateOrInsert(Request $request)
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

        Skripsi::updateOrInsert($request, $validatedData);

        return redirect('/skripsi')->with('success', "Data Skripsi Berhasil Diubah!");
     }
}
