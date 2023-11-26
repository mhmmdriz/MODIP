<?php

namespace App\Http\Controllers\OpDos;

use App\Http\Controllers\Controller;
use App\Models\Skripsi;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class SkripsiController extends Controller
{
    public function index()
    {
        $data_mhs = Mahasiswa::countMahasiswaPerAngkatan();

        $rekap_skripsi = Skripsi::getRekapValidasiSkripsi($data_mhs);

        if(auth()->user()->level == "dosenwali"){
            $path = "dosenwali.skripsi.index";
        }else{
            $path = "operator.validasi_progress_studi.skripsi.index";
        }

        return view($path,[
            "data_mhs" => $data_mhs,
            "rekap_skripsi" => $rekap_skripsi,
        ]);
    }

    public function listMhsAngkatan(String $angkatan)
    {
        $data_mhs = Mahasiswa::getListMhsAngkatan($angkatan, request()->keyword);

        $data_skripsi = Skripsi::pluck('validasi', 'nim')->toArray();
        
        if(auth()->user()->level == "dosenwali"){
            $path = "dosenwali.skripsi.list_mhs";
        }else{
            $path = "operator.validasi_progress_studi.skripsi.list_mhs";
        }

        return view($path,[
            "data_mhs"=> $data_mhs,
            "data_skripsi"=> $data_skripsi,
            "angkatan"=> $angkatan,
        ]);
    }

    public function showSkripsiMhs($angkatan, Mahasiswa $mahasiswa){
        $dataSkripsi = $mahasiswa->skripsi;

        if(auth()->user()->level == "dosenwali"){
            $path = "dosenwali.skripsi.show_skripsi";
        }else{
            $path = "operator.validasi_progress_studi.skripsi.show_skripsi";
        }

        return view($path,[
            'mahasiswa' => $mahasiswa,
            'nim' => $mahasiswa->nim,
            'nama' => $mahasiswa->nama,
            'dataSkripsi' => $dataSkripsi,
            'angkatan' => $angkatan,
        ]);
    }

    public function updateSkripsiMhs($angkatan, Mahasiswa $mahasiswa, Request $request){
        $validatedData = $request->validate([ 
            'semester' => 'required',
            'tanggal_sidang' => 'required',
            'nilai' => 'required',
        ]);

        $mahasiswa->skripsi()->update($validatedData);

        if(auth()->user()->level == "dosenwali"){
            $path = "/skripsiPerwalian/";
        }else{
            $path = "/validasiProgress/validasiSkripsi/";
        }

        return redirect($path . "$angkatan/$mahasiswa->nim")->with('success', "Data Skripsi Berhasil Diubah!");
    }

    public function validateSkripsi(Mahasiswa $mahasiswa, $validate){
        Skripsi::validateSkripsi($mahasiswa, $validate);
        if(auth()->user()->level == "dosenwali"){
            $path = "/skripsiPerwalian/";
        }else{
            $path = "/validasiProgress/validasiSkripsi/";
        }

        return redirect($path . "$mahasiswa->angkatan/$mahasiswa->nim");
    }
}
