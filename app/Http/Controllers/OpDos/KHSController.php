<?php

namespace App\Http\Controllers\OpDos;

use App\Http\Controllers\Controller;
use App\Models\KHS;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class KHSController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_mhs = Mahasiswa::countMahasiswaPerAngkatan();

        $rekap_khs = KHS::getRekapValidasiKHS($data_mhs);

        if(auth()->user()->level == "dosenwali"){
            $path = "dosenwali.khs.index";
        }else{
            $path = "operator.validasi_progress_studi.khs.index";
        }

        return view($path,[
            "data_mhs" => $data_mhs,
            "rekap_khs" => $rekap_khs,
        ]);
    }

    public function listMhsAngkatan(String $angkatan)
    {
        $data_mhs = Mahasiswa::getListMhsAngkatan($angkatan, request()->keyword);
        $data_nim = $data_mhs->pluck("nim");
        $data_khs = KHS::getSKSkIPkList($data_nim);
        
        if(auth()->user()->level == "dosenwali"){
            $path = "dosenwali.khs.list_mhs";
        }else{
            $path = "operator.validasi_progress_studi.khs.list_mhs";
        }

        return view($path,[
            "data_mhs"=> $data_mhs,
            "data_khs"=> $data_khs,
            "angkatan"=> $angkatan,
        ]);
    }

    public function showKHSMhs($angkatan, Mahasiswa $mahasiswa){
        $semesterInfo = $mahasiswa->calculateSemesterAndThnAjar();
        $semester = $semesterInfo['semester'];
        
        $arrKHS = $mahasiswa->khs;
        $dataKHS = KHS::rekapKHS($arrKHS);

        if(auth()->user()->level == "dosenwali"){
            $path = "dosenwali.khs.show_khs";
        }else{
            $path = "operator.validasi_progress_studi.khs.show_khs";
        }

        return view($path,[
            'nim' => $mahasiswa->nim,
            'nama' => $mahasiswa->nama,
            'mahasiswa' => $mahasiswa,
            'khs' => $arrKHS,
            'semester' => $semester,
            'SKSk' => $dataKHS['SKSk'],
            'IPk' => $dataKHS['IPk'],
            'angkatan' => $angkatan,
        ]);
    }

    public function updateKHSMhs($angkatan, Mahasiswa $mahasiswa, Request $request){
        $validated_data = $request->validate([
            'sks' => 'required',
            'sksk' => 'required',
            'ips' => 'required',
            'ipk' => 'required',
        ]);

        $mahasiswa->khs()->where('smt', $request->smt)->update($validated_data);

        if(auth()->user()->level == "dosenwali"){
            $path = "/khsPerwalian/";
        }else{
            $path = "/validasiProgress/validasiKHS/";
        }

        return redirect($path . "$angkatan/$mahasiswa->nim")->with('success', "Data KHS Semester $request->smt Berhasil Diubah!");
    }

    public function validateKHS(){
        KHS::validateKHS(request('validasi'));

        return response()->json([
            'status' => 'success',
            'message' => request('validasi'),
        ]);
    }
}
