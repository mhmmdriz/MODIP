<?php
namespace App\Http\Controllers\Departemen;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Skripsi;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RekapListSkripsiController extends Controller
{
    public function rekap(){
        // $rekap_skripsi = Skripsi::rightJoin("mahasiswa", "mahasiswa.nim", "=", "skripsi.nim")
        // ->groupBy("angkatan")
        // ->selectRaw("angkatan, count(skripsi.nim) as jumlah_sudah, count(mahasiswa.nim) as jumlah_total")
        // ->get()
        // ->groupBy('angkatan') // Mengelompokkan berdasarkan angkatan
        // ->map(function ($group) {
        //     // Mengonversi setiap kelompok menjadi array asosiatif
        //     return [
        //         'sudah_skripsi' => $group->sum('jumlah_sudah'),
        //         'belum_skripsi' => $group->sum('jumlah_total') - $group->sum('jumlah_sudah'),
        //     ];
        // });

        $mhs_skripsi = Skripsi::selectRaw("mahasiswa.nim as mhs_nim, skripsi.nim as skripsi_nim, validasi, angkatan")
        ->rightJoin("mahasiswa", "mahasiswa.nim", "=", "skripsi.nim")
        ->get();

        $rekap_skripsi = $mhs_skripsi->pluck('angkatan')->unique()->mapWithKeys(function ($angkatan) {
            return [$angkatan => [
                'sudah_skripsi' => 0,
                'belum_skripsi' => 0,
            ]];
        })->all();

        foreach($mhs_skripsi as $mhs){
            if($mhs->validasi == 1){
                $rekap_skripsi[$mhs->angkatan]['sudah_skripsi']++;
            }else{
                $rekap_skripsi[$mhs->angkatan]['belum_skripsi']++;
            }
        }

        // dd($rekap_skripsi);
        $current_year = Carbon::now()->year;
        // dd($current_year);
        return view("departemen.rekap_skripsi.index",[
            "rekap_skripsi"=>$rekap_skripsi,
            "current_year"=>$current_year
        ]);
    }

    public function showList(Request $request){
        // if($request->status == "Sudah"){
        //     $data_mhs = Skripsi::join("mahasiswa","mahasiswa.nim","=", "skripsi.nim")->where("angkatan", $request->angkatan)->get();
        // }else{
        //     $data_mhs = Mahasiswa::whereDoesntHave('skripsi')->where("angkatan", $request->angkatan)->get();
        // }
        if($request->status == "Sudah"){
            $data_mhs = Skripsi::join("mahasiswa","mahasiswa.nim","=", "skripsi.nim")->where("angkatan", $request->angkatan)
            ->where("validasi", 1)->get();
        }else{
            $data_mhs = Skripsi::Rightjoin("mahasiswa","mahasiswa.nim","=", "skripsi.nim")->where("angkatan", $request->angkatan)
            ->where(function($query) {
                $query->where('validasi', 0)
                      ->orWhereNull('validasi');
            })
            ->get();
        }

        $view = view('departemen.rekap_skripsi.listMhs',[
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
        return view('departemen.rekap_skripsi.printList',[
            'data_mhs'=> $data_mhs,
            'status' => $request->status,
            'angkatan' => $request->angkatan,
        ]);
    }
    public function printRekap(Request $request){
        $rekap_skripsi = json_decode($request->input('rekap_skripsi'), true);
        // dd($rekap_skripsi, $request->input('status'), $request->angkatan);
        return view('departemen.rekap_skripsi.printRekap',[
            'rekap_skripsi'=> $rekap_skripsi,
            'current_year' => $request->current_year,
        ]);
    }
}
