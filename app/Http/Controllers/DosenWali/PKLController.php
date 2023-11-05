<?php

namespace App\Http\Controllers\DosenWali;

use App\Http\Controllers\Controller;
use App\Models\PKL;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class PKLController extends Controller
{
    public function index()
    {
        $data_mhs = Mahasiswa::where("dosen_wali", auth()->user()->username)->get()->groupBy("angkatan")->map(function($item){
            return $item->count(); 
        });

        return view("dosenwali.pkl.index",[
            "data_mhs" => $data_mhs,
        ]);
    }

    public function listMhsAngkatan(String $angkatan)
    {
        $data_mhs = Mahasiswa::get()->where("dosen_wali", auth()->user()->username)->where("angkatan", $angkatan);

        $data_khs = PKL::get();
        
        return view("dosenwali.pkl.list_mhs",[
            "data_mhs"=> $data_mhs,
            "data_khs"=> $data_khs,
        ]);
    }

    public function showKHSMhs($angkatan, $nim){
        $mahasiswa = Mahasiswa::where("nim","=",$nim)->first();
        $semesterInfo = $mahasiswa->calculateSemesterAndThnAjar();
        $semester = $semesterInfo['semester'];
        
        $dataKHS = $mahasiswa->getKHSArray($semester);
        $arrKHS = $dataKHS['arrKHS'];
        $SKSk = $dataKHS['SKSk'];

        return view('dosenwali.khs.show_khs', [
            'nim' => $nim,
            'khs' => $arrKHS,
            'semester' => $semester,
            // 'smtIRSArray' => $smtIRSArray,
            'SKSk' => $SKSk,
            'angkatan' => $angkatan
        ]);
    }

    public function updateKHSMhs($angkatan, $nim, Request $request){
        $validated_data = $request->validate([
            'sks' => 'required',
            'ips' => 'required',
        ]);

        PKL::where('nim','=',$nim)->where('smt', '=', $request->smt)->update($validated_data);

        return redirect("/khsPerwalian/$angkatan/$nim")->with('success', "Data KHS Semester $request->smt Berhasil Diubah!");
    }

    public function validateKHS(){
        if(request('validasi') == 1){
            PKL::where('nim', '=', request('nim'))->where('smt', '=', request('smt'))->update(['validasi' => 1]);
        }else{
            PKL::where('nim', '=', request('nim'))->where('smt', '=', request('smt'))->update(['validasi' => 0]);
        }

        return response()->json([
            'status' => 'success',
            'message' => request('validasi'),
        ]);
    }
}
