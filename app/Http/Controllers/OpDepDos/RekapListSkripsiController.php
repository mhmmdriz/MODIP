<?php
namespace App\Http\Controllers\OpDepDos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Skripsi;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RekapListSkripsiController extends Controller
{
    public function rekap(){
        $rekap_skripsi = Skripsi::getRekapSkripsi();

        // dd($rekap_skripsi);
        $current_year = Carbon::now()->year;
        if(auth()->user()->level == "dosenwali"){
            $path = "dosenwali.rekap_mhs.rekap_skripsi.index";
        }else{
            $path = "departemen.rekap_skripsi.index";
        }

        return view($path,[
            "rekap_skripsi"=>$rekap_skripsi,
            "current_year"=>$current_year
        ]);
    }

    public function showList(Request $request){
        $data_mhs = Skripsi::getListRekapMhsSkripsi($request);

        if(auth()->user()->level == "dosenwali"){
            $path = "dosenwali.rekap_mhs.rekap_skripsi.listMhs";
        }else{
            $path = "departemen.rekap_skripsi.listMhs";
        }

        $view = view($path,[
            'data_mhs'=> $data_mhs,
            'status' => $request->status,
            'angkatan' => $request->angkatan,
        ])->render();

        return response()->json(['html' => $view]);
    }

    public function printList(Request $request){
        $data_mhs = json_decode($request->input('objects'), true);
        // dd($data_mhs, $request->input('status'), $request->angkatan);
        if(auth()->user()->level == "dosenwali"){
            $path = "dosenwali.rekap_mhs.rekap_skripsi.printList";
        }else{
            $path = "departemen.rekap_skripsi.printList";
        }

        return view($path,[
            'data_mhs'=> $data_mhs,
            'status' => $request->status,
            'angkatan' => $request->angkatan,
        ]);
    }

    public function printRekap(Request $request){
        $rekap_skripsi = json_decode($request->input('rekap_skripsi'), true);
        // dd($rekap_skripsi, $request->input('status'), $request->angkatan);
        if(auth()->user()->level == "dosenwali"){
            $path = "dosenwali.rekap_mhs.rekap_skripsi.printRekap";
        }else{
            $path = "departemen.rekap_skripsi.printRekap";
        }

        return view($path,[
            'rekap_skripsi'=> $rekap_skripsi,
            'current_year' => $request->current_year,
        ]);
    }
}
