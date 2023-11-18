<?php

namespace App\Http\Controllers\Departemen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PKL;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class RekapListPKLController extends Controller
{
    public function rekap(){
        // $rekap_pkl = PKL::rightJoin("mahasiswa", "mahasiswa.nim", "=", "pkl.nim")
        // ->groupBy("angkatan")
        // ->selectRaw("angkatan, count(pkl.nim) as jumlah_sudah, count(mahasiswa.nim) as jumlah_total")
        // ->get()
        // ->groupBy('angkatan') // Mengelompokkan berdasarkan angkatan
        // ->map(function ($group) {
        //     // Mengonversi setiap kelompok menjadi array asosiatif
        //     return [
        //         'sudah_pkl' => $group->sum('jumlah_sudah'),
        //         'belum_pkl' => $group->sum('jumlah_total') - $group->sum('jumlah_sudah'),
        //     ];
        // });

        // $rekap_pkl = PKL::rightJoin("mahasiswa", "mahasiswa.nim", "=", "pkl.nim")
        // ->groupBy("angkatan")
        // ->selectRaw("angkatan, 
        //             COUNT(CASE WHEN pkl.validasi = 1 THEN pkl.nim ELSE NULL END) as jumlah_sudah,
        //             COUNT(mahasiswa.nim) as jumlah_total")
        // ->get()
        // ->groupBy('angkatan')
        // ->map(function ($group) {
        //     return [
        //         'sudah_pkl' => $group->sum('jumlah_sudah'),
        //         'belum_pkl' => $group->sum('jumlah_total') - $group->sum('jumlah_sudah'),
        //     ];
        // });
        $mhs_pkl = PKL::selectRaw("mahasiswa.nim as mhs_nim, pkl.nim as pkl_nim, validasi, angkatan")
        ->rightJoin("mahasiswa", "mahasiswa.nim", "=", "pkl.nim")
        ->get();

        $rekap_pkl = $mhs_pkl->pluck('angkatan')->unique()->mapWithKeys(function ($angkatan) {
            return [$angkatan => [
                'sudah_pkl' => 0,
                'belum_pkl' => 0,
            ]];
        })->all();

        foreach($mhs_pkl as $mhs){
            if($mhs->validasi == 1){
                $rekap_pkl[$mhs->angkatan]['sudah_pkl']++;
            }else{
                $rekap_pkl[$mhs->angkatan]['belum_pkl']++;
            }
        }
        
        // dd($rekap_pkl);

        $current_year = Carbon::now()->year;
        // dd($current_year);
        return view("departemen.rekap_pkl.index",[
            "rekap_pkl"=>$rekap_pkl,
            "current_year"=>$current_year
        ]);
    }

    public function showList(Request $request){
        if($request->status == "Sudah"){
            $data_mhs = PKL::join("mahasiswa","mahasiswa.nim","=", "pkl.nim")->where("angkatan", $request->angkatan)
            ->where("validasi", 1)->get();
        }else{
            $data_mhs = PKL::Rightjoin("mahasiswa","mahasiswa.nim","=", "pkl.nim")->where("angkatan", $request->angkatan)
            ->where(function($query) {
                $query->where('validasi', 0)
                      ->orWhereNull('validasi');
            })
            ->get();
        }

        $view = view('departemen.rekap_pkl.listMhs',[
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
        return view('departemen.rekap_pkl.printList',[
            'data_mhs'=> $data_mhs,
            'status' => $request->status,
            'angkatan' => $request->angkatan,
        ]);
    }
    public function printRekap(Request $request){
        $rekap_pkl = json_decode($request->input('rekap_pkl'), true);
        // dd($rekap_pkl, $request->input('status'), $request->angkatan);
        return view('departemen.rekap_pkl.printRekap',[
            'rekap_pkl'=> $rekap_pkl,
            'current_year' => $request->current_year,
        ]);
    }
}
