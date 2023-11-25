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
        $data_mhs = Mahasiswa::where("dosen_wali", auth()->user()->username)->orderBy("angkatan")->get()->groupBy("angkatan")->map(function($item){
            return $item->count(); 
        });

        $rekap_pkl = PKL::getRekapValidasiPKL($data_mhs, auth()->user()->username);

        
        return view("dosenwali.pkl.index",[
            "data_mhs" => $data_mhs,
            "rekap_pkl" => $rekap_pkl,
        ]);
    }

    public function listMhsAngkatan(String $angkatan)
    {
        $data_mhs = Mahasiswa::get()->where("dosen_wali", auth()->user()->username)->where("angkatan", $angkatan);

        $data_pkl = PKL::pluck('validasi', 'nim')->toArray();
        // dd($data_pkl);
        
        return view("dosenwali.pkl.list_mhs",[
            "data_mhs"=> $data_mhs,
            "data_pkl"=> $data_pkl,
            'angkatan' => $angkatan,
        ]);
    }

    public function showPKLMhs($angkatan, $nim){
        $mahasiswa = Mahasiswa::where("nim","=",$nim)->first();
        
        $dataPKL = $mahasiswa->pkl;

        return view('dosenwali.pkl.show_pkl', [
            'nim' => $nim,
            'nama' => $mahasiswa->nama,
            'dataPKL' => $dataPKL,
            'angkatan' => $angkatan,
        ]);
    }

    public function updatePKLMhs($angkatan, $nim, Request $request){
        $status = $request->status;
        $mahasiswa = Mahasiswa::where('nim', $nim)->first();
        $nama = $mahasiswa->nama;
        $validasi = 0;
        // dd($request->status_old);
        if ($status == ""){
            return redirect("/pklPerwalian/$angkatan/$nim");
        }
        //else
        $rules = [ 
            'semester' => 'required',
            'tanggal_seminar' => 'required',
            'nilai' => 'required',
        ];
        $validatedData = $request->validate($rules);

        if ($request->status_old == null){
            $validatedData['nim'] = $nim;
            $validatedData['nama'] = $nama;
            $validatedData['status'] = $status;
            $validatedData['validasi'] = $validasi;
            PKL::create($validatedData);
        } else {
            $validatedData['status'] = $status;
            PKL::where("nim", $nim)->update($validatedData);
        }

        return redirect("/pklPerwalian/$angkatan/$nim")->with('success', "Data PKL Berhasil Diubah!");
    }

    public function validatePKL($angkatan, $nim, $validate){

        PKL::where('nim', '=', $nim)->update(['validasi' => $validate]);

        return redirect("/pklPerwalian/$angkatan/$nim");
    }
}