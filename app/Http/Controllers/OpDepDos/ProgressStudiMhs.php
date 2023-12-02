<?php

namespace App\Http\Controllers\OpDepDos;

use App\Http\Controllers\Controller;
use App\Models\IRS;
use App\Models\KHS;
use App\Models\Mahasiswa;
use App\Models\Skripsi;
use App\Models\PKL;
use Illuminate\Http\Request;

class ProgressStudiMhs extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        if(auth()->user()->level=="dosenwali"){
            $data_mhs = Mahasiswa::get()->where("dosen_wali", auth()->user()->username);
            $path = "dosenwali.pencarian_progress.index";
        }else{
            $data_mhs = Mahasiswa::all();
            $path = "departemen.pencarian_progress.index";
        }
        $data_angkatan = Mahasiswa::getAngkatan($data_mhs);

        return view($path,[
            "data_mhs" => $data_mhs,
            "data_angkatan" => $data_angkatan,
        ]);
    }

    public function updateTableProgressMhs(Request $request){
        $view = Mahasiswa::updateViewProgressMhs($request);

        return response()->json(['html' => $view]);
    }

    public function showProgressMhs(Mahasiswa $mahasiswa){
        $semesterInfo = $mahasiswa->calculateSemesterAndThnAjar();
        $semester = $semesterInfo['semester'];

        $arrIRS = $mahasiswa->irs;

        $arrKHS = $mahasiswa->khs;
        $data_khs = KHS::rekapKHS($arrKHS);

        $data_skripsi = $mahasiswa->skripsi;
        $data_pkl = $mahasiswa->pkl;
        // dd($data_skripsi, $data_pkl, $arrIRS, $arrKHS);

        if(auth()->user()->level == "dosenwali"){
            $path = "dosenwali.pencarian_progress.show_progress";
        }else{
            $path = "departemen.pencarian_progress.show_progress";
        }

        return view($path,[
            "mahasiswa" => $mahasiswa,
            "semester" => $semester,
            "data_skripsi" => $data_skripsi,
            "data_pkl" => $data_pkl,
            "arrIRS" => $arrIRS,
            "arrKHS" => $arrKHS,
            "SKSk" => $data_khs['SKSk'],
            "IPk" => $data_khs['IPk'],
        ]);
    }
}
