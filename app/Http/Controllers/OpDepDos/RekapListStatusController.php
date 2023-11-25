<?php

namespace App\Http\Controllers\OpDepDos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RekapListStatusController extends Controller
{
    public function rekap(){
        $rekap_status = Mahasiswa::getRekapStatus();

        // dd($rekap_status);
        $current_year = Carbon::now()->year;
        if(auth()->user()->level == "dosenwali"){
            $path = "dosenwali.rekap_mhs.rekap_status.index";
        }else{
            $path = "departemen.rekap_status.index";
        }

        return view($path,[
            "rekap_status"=>$rekap_status,
            "current_year"=>$current_year
        ]);
    }

    public function showListAjax(Request $request){
        $data_mhs = Mahasiswa::getListRekapStatus($request);

        if(auth()->user()->level == "dosenwali"){
            $path = "dosenwali.rekap_mhs.rekap_status.ajax";
        }else{
            $path = "departemen.rekap_status.ajax";
        }

        $view = view($path,[
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
        
        if(auth()->user()->level == "dosenwali"){
            $path = "dosenwali.rekap_mhs.rekap_status.printList";
        }else{
            $path = "departemen.rekap_status.printList";
        }

        return view($path,[
            'data_mhs'=> $data_mhs,
            'status' => $request->status,
            'angkatan' => $request->angkatan,
        ]);
    }
    public function printRekap(Request $request){
        $rekap_status = json_decode($request->input('rekap_status'), true);
        // dd($rekap_status, $request->input('status'), $request->angkatan);
        if(auth()->user()->level == "dosenwali"){
            $path = "dosenwali.rekap_mhs.rekap_status.printRekap";
        }else{
            $path = "departemen.rekap_status.printRekap";
        }

        return view($path,[
            'rekap_status'=> $rekap_status,
            'current_year' => $request->current_year,
        ]);
    }
}
