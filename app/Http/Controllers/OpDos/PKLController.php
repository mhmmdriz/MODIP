<?php

namespace App\Http\Controllers\OpDos;

use App\Http\Controllers\Controller;
use App\Models\PKL;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class PKLController extends Controller
{
    public function index()
    {
        $data_mhs = Mahasiswa::countMahasiswaPerAngkatan();

        $rekap_pkl = PKL::getRekapValidasiPKL($data_mhs);

        if(auth()->user()->level == "dosenwali"){
            $path = "dosenwali.pkl.index";
        }else{
            $path = "operator.validasi_progress_studi.pkl.index";
        }

        return view($path,[
            "data_mhs" => $data_mhs,
            "rekap_pkl" => $rekap_pkl,
        ]);
    }

    public function listMhsAngkatan(String $angkatan)
    {
        $data_mhs = Mahasiswa::getListMhsAngkatan($angkatan, request()->keyword);

        $data_pkl = PKL::pluck('validasi', 'nim')->toArray();
        
        if(auth()->user()->level == "dosenwali"){
            $path = "dosenwali.pkl.list_mhs";
        }else{
            $path = "operator.validasi_progress_studi.pkl.list_mhs";
        }

        return view($path,[
            "data_mhs"=> $data_mhs,
            "data_pkl"=> $data_pkl,
            'angkatan' => $angkatan,
        ]);
    }

    public function showPKLMhs($angkatan, Mahasiswa $mahasiswa){
        $dataPKL = $mahasiswa->pkl;

        if(auth()->user()->level == "dosenwali"){
            $path = "dosenwali.pkl.show_pkl";
        }else{
            $path = "operator.validasi_progress_studi.pkl.show_pkl";
        }

        return view($path,[
            'mahasiswa' => $mahasiswa,
            'nim' => $mahasiswa->nim,
            'nama' => $mahasiswa->nama,
            'dataPKL' => $dataPKL,
            'angkatan' => $angkatan,
        ]);
    }

    public function updatePKLMhs($angkatan, Mahasiswa $mahasiswa, Request $request){
        $validatedData = $request->validate([
            'semester' => 'required',
            'tanggal_seminar' => 'required',
            'nilai' => 'required',
        ]);

        $mahasiswa->pkl()->update($validatedData);

        if(auth()->user()->level == "dosenwali"){
            $path = "/pklPerwalian/";
        }else{
            $path = "/validasiProgress/validasiPKL/";
        }

        return redirect($path . "$angkatan/$mahasiswa->nim")->with('success', "Data PKL Berhasil Diubah!");
    }

    public function validatePKL(Mahasiswa $mahasiswa, $validate){
        PKL::validatePKL($mahasiswa, $validate);
        if(auth()->user()->level == "dosenwali"){
            $path = "/pklPerwalian/";
        }else{
            $path = "/validasiProgress/validasiPKL/";
        }

        return redirect($path . "$mahasiswa->angkatan/$mahasiswa->nim");
    }
}
