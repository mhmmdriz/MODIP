<?php

namespace App\Http\Controllers\Departemen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RekapListStatusController extends Controller
{
    public function rekap(){
        $rekap_status = Mahasiswa::groupBy('angkatan', 'status')
        ->selectRaw('angkatan, status, count(nim) as jumlah')
        ->get()
        ->groupBy('angkatan')
        ->map(function ($group) {
            return $group->pluck('jumlah', 'status');
        });

        // dd($rekap_status);
        $current_year = Carbon::now()->year;
        // dd($current_year);
        return view("departemen.rekap_status.index",[
            "rekap_status"=>$rekap_status,
            "current_year"=>$current_year
        ]);
    }

    public function showList($angkatan, $status=null){
        // dd($angkatan, $status);

        $whereQuery = "angkatan = $angkatan";
        if($status!=null){
            $whereQuery .= " AND status = '$status'";
        }
        $data_mhs = Mahasiswa::whereRaw($whereQuery)->get();
        // dd($data_mhs);

        $current_year = Carbon::now()->year;
        
        return view("departemen.rekap_status.listMhs",[
            "data_mhs"=>$data_mhs,
            "status"=>$status,
            "angkatan"=>$angkatan,
            "current_year"=>$current_year
        ]);
    }

    public function showListAjax(Request $request){
        $angkatan = $request->angkatan;

        $whereQuery = "angkatan = $angkatan";

        if($request->status != null){
            $whereQuery .= " AND status = '".$request->status."'";
        }

        $data_mhs = Mahasiswa::whereRaw($whereQuery)->get();

        $view = view('departemen.rekap_status.ajax',[
            'data_mhs'=> $data_mhs,
            'status' => $request->status,
            'angkatan' => $request->angkatan,
        ])->render();
        return response()->json(['html' => $view]);
        // return response()->json(['html' => $tes]);
    }

    public function printList(Request $request){
        $data_mhs = json_decode($request->input('objects'), true);
        // dd($data_mhs, $request->input('status'), $request->angkatan);
        
        return view('departemen.rekap_status.printList',[
            'data_mhs'=> $data_mhs,
            'status' => $request->status,
            'angkatan' => $request->angkatan,
        ]);
    }
    public function printRekap(Request $request){
        $rekap_status = json_decode($request->input('rekap_status'), true);
        // dd($rekap_status, $request->input('status'), $request->angkatan);
        return view('departemen.rekap_status.printRekap',[
            'rekap_status'=> $rekap_status,
            'current_year' => $request->current_year,
        ]);
    }
}
