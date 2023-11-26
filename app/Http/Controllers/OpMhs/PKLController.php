<?php

namespace App\Http\Controllers\OpMhs;

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
        $semesterInfo = $mahasiswa->calculateSemesterAndThnAjar();
        $semester = $semesterInfo['semester'];
        
        $is_eligible = PKL::isEligible($semester);

        return view('mahasiswa.pkl.index', [
            'dataPKL' => $dataPKL,
            'is_eligible' => $is_eligible,
        ]);
    }

    public function updateOrInsert(Request $request)
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

        PKL::updateOrInsert($request, $validatedData);

        return redirect('/pkl')->with('success', "Data PKL Berhasil Diubah!");
    }
}

