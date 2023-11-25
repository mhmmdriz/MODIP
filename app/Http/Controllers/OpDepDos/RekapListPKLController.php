<?php

namespace App\Http\Controllers\OpDepDos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PKL;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class RekapListPKLController extends Controller
{
    public function rekap(){
        $rekap_pkl = PKL::getRekapPKL();
        
        $current_year = Carbon::now()->year;
        
        if(auth()->user()->level == "dosenwali"){
            $path = "dosenwali.rekap_mhs.rekap_pkl.index";
        }else{
            $path = "departemen.rekap_pkl.index";
        }

        return view($path,[
            "rekap_pkl"=>$rekap_pkl,
            "current_year"=>$current_year
        ]);
    }

    public function showList(Request $request){
        $data_mhs = PKL::getListRekapMhsPKL($request);

        if(auth()->user()->level == "dosenwali"){
            $path = "dosenwali.rekap_mhs.rekap_pkl.listMhs";
        }else{
            $path = "departemen.rekap_pkl.listMhs";
        }

        $view = view($path,[
            'data_mhs'=> $data_mhs,
            'status' => $request->status,
            'angkatan' => $request->angkatan,
        ])->render();

        return response()->json(['html' => $view]);
        // return response()->json(["message"=>$view]);
    }

    public function printList(Request $request){
        $data_mhs = json_decode($request->input('objects'), true);
        // dd($data_mhs, $request->input('status'), $request->angkatan);
        if(auth()->user()->level == "dosenwali"){
            $path = "dosenwali.rekap_mhs.rekap_pkl.printList";
        }else{
            $path = "departemen.rekap_pkl.printList";
        }

        return view($path,[
            'data_mhs'=> $data_mhs,
            'status' => $request->status,
            'angkatan' => $request->angkatan,
        ]);
    }
    
    public function printRekap(Request $request){
        $rekap_pkl = json_decode($request->input('rekap_pkl'), true);
        // dd($rekap_pkl, $request->input('status'), $request->angkatan);
        if(auth()->user()->level == "dosenwali"){
            $path = "dosenwali.rekap_mhs.rekap_pkl.printRekap";
        }else{
            $path = "departemen.rekap_pkl.printRekap";
        }

        return view($path,[
            'rekap_pkl'=> $rekap_pkl,
            'current_year' => $request->current_year,
        ]);
    }
}
