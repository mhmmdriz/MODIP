<?php

namespace App\Http\Controllers\Departemen;

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
        $data_mhs = Mahasiswa::all();
        $data_angkatan = $data_mhs->pluck('angkatan')->unique()->values();

        return view("departemen.pencarian_progress.index",[
            "data_mhs" => $data_mhs,
            "data_angkatan" => $data_angkatan,
        ]);
    }

    public function updateTableProgressMhs(Request $request){
        $whereQuery = "";
        if($request->keyword != ""){
            $whereQuery .= "nim LIKE '%$request->keyword%' OR nama LIKE '%$request->keyword%'";
        }
        if($request->angkatan != ""){
            if($whereQuery != ""){
                $whereQuery .= " AND angkatan = '$request->angkatan'";
            }else{
                $whereQuery .= "angkatan = '$request->angkatan'";
            }
        }

        if($whereQuery != ""){
            $data_mhs = Mahasiswa::whereRaw($whereQuery)->get();
        }else{
            $data_mhs = Mahasiswa::all();
        }
        
        $view = view('departemen.pencarian_progress.update_mhs')->with('data_mhs', $data_mhs)->render();

        return response()->json(['html' => $view, 'message' => $whereQuery]);
    }

    public function showProgressMhs($nim){
        $mahasiswa = Mahasiswa::where('nim', $nim)->first();
        $semesterInfo = $mahasiswa->calculateSemesterAndThnAjar();
        $semester = $semesterInfo['semester'];

        $dataIRS = $mahasiswa->getIRSArray($semester);
        $arrIRS = $dataIRS['arrIRS'];
        $dataKHS = $mahasiswa->getKHSArray($semester);
        $arrKHS = $dataKHS['arrKHS'];

        $data_skripsi = Skripsi::where('nim', $nim)->first();
        $data_pkl = PKL::where('nim', $nim)->first();
        // dd($mahasiswa->dosenwali);
        // dd($data_skripsi, $data_pkl, $arrIRS, $arrKHS);

        return view("departemen.pencarian_progress.show_progress",[
            "mahasiswa" => $mahasiswa,
            "semester" => $semester,
            "data_skripsi" => $data_skripsi,
            "data_pkl" => $data_pkl,
            "arrIRS" => $arrIRS,
            "arrKHS" => $arrKHS,
        ]);
    }
}
