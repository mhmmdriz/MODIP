<?php

namespace App\Http\Controllers\DosenWali;

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
        $data_mhs = Mahasiswa::get()->where("dosen_wali", auth()->user()->username);
        $data_angkatan = Mahasiswa::getAngkatan($data_mhs);

        return view("dosenwali.pencarian_progress.index",[
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
        $SKSkIRS = 0;
        foreach($arrIRS as $irs){
            $SKSkIRS += $irs->sks;
        }

        $arrKHS = $mahasiswa->khs;
        
        $dataKHS = KHS::rekapKHS($arrKHS);

        $data_skripsi = $mahasiswa->skripsi;
        $data_pkl = $mahasiswa->pkl;

        return view("dosenwali.pencarian_progress.show_progress",[
            "mahasiswa" => $mahasiswa,
            "semester" => $semester,
            "data_skripsi" => $data_skripsi,
            "data_pkl" => $data_pkl,
            "arrIRS" => $arrIRS,
            "arrKHS" => $arrKHS,
            "SKSkIRS" => $SKSkIRS,
            'SKSkKHS' => $dataKHS['SKSk'],
            'IPk' => $dataKHS['IPk'],
        ]);
    }
}
