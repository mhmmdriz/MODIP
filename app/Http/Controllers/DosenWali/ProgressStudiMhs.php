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
        $data_angkatan = $data_mhs->pluck('angkatan')->unique()->values();

        return view("dosenwali.pencarian_progress.index",[
            "data_mhs" => $data_mhs,
            "data_angkatan" => $data_angkatan,
        ]);
    }

    public function updateTableProgressMhs(Request $request){
        $whereQuery = "dosen_wali = ". auth()->user()->username;
        if($request->keyword != ""){
            $whereQuery .= " AND nim LIKE '%$request->keyword%' OR nama LIKE '%$request->keyword%'";
        }
        if($request->angkatan != ""){
            $whereQuery .= " AND angkatan = '$request->angkatan'";
        }

        $data_mhs = Mahasiswa::whereRaw($whereQuery)->get();
        
        $view = view('departemen.pencarian_progress.update_mhs')->with('data_mhs', $data_mhs)->render();

        return response()->json(['html' => $view, 'message' => $whereQuery]);
    }

    public function showProgressMhs($nim){
        $mahasiswa = Mahasiswa::where('nim', $nim)->first();
        $semesterInfo = $mahasiswa->calculateSemesterAndThnAjar();
        $semester = $semesterInfo['semester'];

        $arrIRS = $mahasiswa->irs;
        $SKSkIRS = 0;
        foreach($arrIRS as $irs){
            $SKSkIRS += $irs->sks;
        }

        $arrKHS = $mahasiswa->khs;
        $SKSkKHS = 0;
        $IPK = 0;
        foreach($arrKHS as $khs){
            $SKSkKHS += $khs->sks;
            $IPK += $khs->ips;
        }

        $data_skripsi = Skripsi::where('nim', $nim)->first();
        $data_pkl = PKL::where('nim', $nim)->first();
        // dd($mahasiswa->dosenwali);
        // dd($data_skripsi, $data_pkl, $arrIRS, $arrKHS);

        return view("dosenwali.pencarian_progress.show_progress",[
            "mahasiswa" => $mahasiswa,
            "semester" => $semester,
            "data_skripsi" => $data_skripsi,
            "data_pkl" => $data_pkl,
            "arrIRS" => $arrIRS,
            "arrKHS" => $arrKHS,
            "SKSkIRS" => $SKSkIRS,
            "SKSkKHS" => $SKSkKHS,
        ]);
    }
}
