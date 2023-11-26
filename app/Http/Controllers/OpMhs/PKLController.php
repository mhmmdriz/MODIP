<?php

namespace App\Http\Controllers\OpMhs;

use App\Http\Controllers\Controller;
use App\Models\PKL;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class PKLController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Mahasiswa $mahasiswa) 
    {
        if (auth()->user()->level == "mahasiswa") {
            $mahasiswa = auth()->user()->mahasiswa;
        }
        $dataPKL = $mahasiswa->pkl;
        $semesterInfo = $mahasiswa->calculateSemesterAndThnAjar();
        $semester = $semesterInfo['semester'];
        
        $is_eligible = PKL::isEligible($semester);

        return view('mahasiswa.pkl.index', [
            'mahasiswa' => $mahasiswa,
            'dataPKL' => $dataPKL,
            'is_eligible' => $is_eligible,
        ]);
    }

    public function updateOrInsert(Mahasiswa $mahasiswa, Request $request)
    {
        $rules = [ 
            'semester' => 'required',
            'tanggal_seminar' => 'required',
            'nilai' => 'required',
        ];
        if ($request->scan_basp_old == null) {
            $rules['scan_basp'] = 'required|mimes:pdf|max:10000';
        }
        $validatedData = $request->validate($rules);

        PKL::updateOrInsert($mahasiswa, $request, $validatedData);

        if (auth()->user()->level == "mahasiswa") {
            return redirect('/pkl')->with('success', "Data PKL Berhasil Diubah!");
        } else {
            return redirect('/entryProgress/entryPKL/' . $mahasiswa->nim)->with('success', "Data PKL Berhasil Diubah!");
        }
    }
}

