<?php

namespace App\Http\Controllers\DosenWali;

use App\Http\Controllers\Controller;
use App\Models\Skripsi;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SkripsiController extends Controller
{
    public function index()
    {
        $data_mhs = Mahasiswa::where("dosen_wali", auth()->user()->username)->get()->groupBy("angkatan")->map(function($item){
            return $item->count(); 
        });

        return view("dosenwali.skripsi.index",[
            "data_mhs" => $data_mhs,
        ]);
    }

    public function listMhsAngkatan(String $angkatan)
    {
        $data_mhs = Mahasiswa::get()->where("dosen_wali", auth()->user()->username)->where("angkatan", $angkatan);

        $data_skripsi = Skripsi::pluck('validasi', 'nim')->toArray();
        // dd($data_skripsi);
        
        return view("dosenwali.skripsi.list_mhs",[
            "data_mhs"=> $data_mhs,
            "data_skripsi"=> $data_skripsi,
            "angkatan"=> $angkatan,
        ]);
    }

    public function showSkripsiMhs($angkatan, $nim){
        $mahasiswa = Mahasiswa::where("nim","=",$nim)->first();
        
        $dataSkripsi = $mahasiswa->skripsi;

        return view('dosenwali.skripsi.show_skripsi', [
            'nim' => $nim,
            'nama' => $mahasiswa->nama,
            'dataSkripsi' => $dataSkripsi,
            'angkatan' => $angkatan,
        ]);
    }

    public function updateSkripsiMhs($angkatan, $nim, Request $request){
        $status = $request->status;
        $mahasiswa = Mahasiswa::where('nim', $nim)->first();
        $nama = $mahasiswa->nama;
        $validasi = 0;
        // dd($request->status_old);
        if ($status == ""){
            return redirect("/skripsiPerwalian/$angkatan/$nim");
        }
        if ($request->status_old == null){
            if ($status == "Belum Ambil"){
                Skripsi::create(['nim' => $nim, 'nama' => $nama, 'status' => $status, 'validasi' => $validasi]);
            } else if ($status == "Sedang Ambil") {
                Skripsi::create(['nim' => $nim, 'nama' => $nama, 'status' => $status, 'validasi' => $validasi]);
            } else {
                $rules = [ 
                    'tanggal_sidang' => 'required',
                    'tanggal_lulus' => 'required',
                    'nilai' => 'required',
                ];
                
                $tgl_lulus = Carbon::parse($request->tanggal_lulus);
                $semester = ($tgl_lulus->year - $mahasiswa->angkatan) * 2 + 1;
                if ($tgl_lulus->gt(Carbon::createFromDate($tgl_lulus->year, 2, 15)) && $tgl_lulus->lte(Carbon::createFromDate($tgl_lulus->year, 8, 15))) {
                    $semester -= 1;
                } else if ($tgl_lulus->lte(Carbon::createFromDate($tgl_lulus->year, 2, 15))) {
                    $semester -= 2;
                }
                $validatedData = $request->validate($rules);

                $validatedData['semester'] = $semester;
                $validatedData['nim'] = $nim;
                $validatedData['nama'] = $nama;
                $validatedData['status'] = $status;
                $validatedData['validasi'] = $validasi;
                // dd($semester);
                Skripsi::create($validatedData);
            }
        } else {
            if ($status == "Belum Ambil"){
                Skripsi::where("nim", $nim)->update(['semester' => null, 'status' => $status, 'tanggal_sidang' => null, 'tanggal_lulus' => null, 'nilai' => null, 'scan_bass' => null]);
            } else if ($status == "Sedang Ambil") {
                Skripsi::where("nim", $nim)->update(['semester' => null, 'status' => $status, 'tanggal_sidang' => null, 'tanggal_lulus' => null, 'nilai' => null, 'scan_bass' => null]);
            } else {
                $rules = [ 
                    'tanggal_sidang' => 'required',
                    'tanggal_lulus' => 'required',
                    'nilai' => 'required',
                ];
                
                $tgl_lulus = Carbon::parse($request->tanggal_lulus);
                $semester = ($tgl_lulus->year - $mahasiswa->angkatan) * 2 + 1;
                if ($tgl_lulus->gt(Carbon::createFromDate($tgl_lulus->year, 2, 15)) && $tgl_lulus->lte(Carbon::createFromDate($tgl_lulus->year, 8, 15))) {
                    $semester -= 1;
                } else if ($tgl_lulus->lte(Carbon::createFromDate($tgl_lulus->year, 2, 15))) {
                    $semester -= 2;
                }
                $validatedData = $request->validate($rules);

                $validatedData['semester'] = $semester;
                // $validatedData['nim'] = $nim; 1
                // $validatedData['nama'] = $nama; 2
                $validatedData['status'] = $status;
                // $validatedData['validasi'] = $validasi; 3
                // dd($semester);
                Skripsi::where("nim", $nim)->update($validatedData);
            }
            
        }
        return redirect("/skripsiPerwalian/$angkatan/$nim")->with('success', "Data Skripsi Berhasil Diubah!");
    }

    public function validateSkripsi($angkatan, $nim, $validate){

        Skripsi::where('nim', '=', $nim)->update(['validasi' => $validate]);

        return redirect("/skripsiPerwalian/$angkatan/$nim");
    }
}
