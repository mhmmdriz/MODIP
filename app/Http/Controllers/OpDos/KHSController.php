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
        $data_mhs = Mahasiswa::where("dosen_wali", auth()->user()->username)->get()->groupBy("angkatan")->map(function($item){
            return $item->count(); 
        });

        $rekap_khs = KHS::getRekapKHSAngkatan($data_mhs, auth()->user()->username);

        return view("dosenwali.khs.index",[
            "data_mhs" => $data_mhs,
            "rekap_khs" => $rekap_khs,
        ]);
    }

    public function listMhsAngkatan(String $angkatan)
    {
        $data_mhs = Mahasiswa::get()->where("dosen_wali", auth()->user()->username)->where("angkatan", $angkatan);
        $data_nim = $data_mhs->pluck("nim");
        $data_khs = KHS::getSKSkIPkList($data_nim);
        // dd($data_khs);
        
        return view("dosenwali.khs.list_mhs",[
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

        return view('dosenwali.khs.show_khs', [
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

        return redirect("/khsPerwalian/$angkatan/$mahasiswa->nim")->with('success', "Data KHS Semester $request->smt Berhasil Diubah!");
    }

    public function validateKHS(){
        if(request('validasi') == 1){
            KHS::where('nim', request('nim'))->where('smt', request('smt'))->update(['validasi' => 1]);
        }else{
            KHS::where('nim', request('nim'))->where('smt', request('smt'))->update(['validasi' => 0]);
        }

        return response()->json([
            'status' => 'success',
            'message' => request('validasi'),
        ]);
    }
}
