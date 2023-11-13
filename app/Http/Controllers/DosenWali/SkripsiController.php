<?php

namespace App\Http\Controllers\DosenWali;

use App\Http\Controllers\Controller;
use App\Models\Skripsi;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

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
        //else
        $rules = [ 
            'semester' => 'required',
            'tanggal_sidang' => 'required',
            'nilai' => 'required',
        ];
        $validatedData = $request->validate($rules);

        if ($request->status_old == null){
            $validatedData['nim'] = $nim;
            $validatedData['nama'] = $nama;
            $validatedData['status'] = $status;
            $validatedData['validasi'] = $validasi;
            Skripsi::create($validatedData);
        } else {
            // $validatedData['nim'] = $nim; 1
            // $validatedData['nama'] = $nama; 2
            $validatedData['status'] = $status;
            // $validatedData['validasi'] = $validasi; 3
            Skripsi::where("nim", $nim)->update($validatedData);
        }

        return redirect("/skripsiPerwalian/$angkatan/$nim")->with('success', "Data Skripsi Berhasil Diubah!");
    }

    public function validateSkripsi($angkatan, $nim, $validate){

        Skripsi::where('nim', '=', $nim)->update(['validasi' => $validate]);

        return redirect("/skripsiPerwalian/$angkatan/$nim");
    }
}
