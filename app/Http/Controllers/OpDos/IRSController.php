<?php

namespace App\Http\Controllers\OpDos;

use App\Http\Controllers\Controller;
use App\Models\IRS;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class IRSController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(auth()->user()->level == "dosenwali"){
            $data_mhs = Mahasiswa::where("dosen_wali", auth()->user()->username)->get()->groupBy("angkatan")->map(function($item){
                return $item->count(); 
            });
        }else{
            $data_mhs = Mahasiswa::get()->groupBy("angkatan")->map(function($item){
                return $item->count(); 
            });
        }
        
        $rekap_irs = IRS::getRekapValidasiIRS($data_mhs);

        if(auth()->user()->level == "dosenwali"){
            $path = "dosenwali.irs.index";
        }else{
            $path = "operator.validasi_progress_studi.irs.index";
        }

        return view($path,[
            "data_mhs" => $data_mhs,
            "rekap_irs" => $rekap_irs,
        ]);
    }

    public function listMhsAngkatan(String $angkatan)
    {
        $data_mhs = Mahasiswa::getListMhsAngkatan($angkatan);
        $data_nim = $data_mhs->pluck("nim");
        $data_irs = IRS::getSKSkList($data_nim);

        if(auth()->user()->level == "dosenwali"){
            $path = "dosenwali.irs.list_mhs";
        }else{
            $path = "operator.validasi_progress_studi.irs.list_mhs";
        }

        return view($path,[
            "data_mhs"=> $data_mhs,
            "data_irs"=> $data_irs,
            "angkatan"=> $angkatan,
        ]);
    }

    public function showIRSMhs($angkatan, Mahasiswa $mahasiswa){
        $semesterInfo = $mahasiswa->calculateSemesterAndThnAjar();
        $semester = $semesterInfo['semester'];
        
        $arrIRS = $mahasiswa->irs;
        $SKSk = 0;
        foreach($arrIRS as $irs){
            $SKSk += $irs->sks;
        }

        if(auth()->user()->level == "dosenwali"){
            $path = "dosenwali.irs.show_irs";
        }else{
            $path = "operator.validasi_progress_studi.irs.show_irs";
        }

        return view($path,[
            'nim' => $mahasiswa->nim,
            'mahasiswa' => $mahasiswa,
            'irs' => $arrIRS,
            'semester' => $semester,
            'SKSk' => $SKSk,
            'angkatan'=> $angkatan,
        ]);
    }

    public function updateIRSMhs($angkatan, Mahasiswa $mahasiswa, Request $request){
        $validated_data = $request->validate([
            'sks' => 'required',
        ]);

        $mahasiswa->irs()->where('smt', $request->smt)->update($validated_data);

        if(auth()->user()->level == "dosenwali"){
            $path = "/irsPerwalian/";
        }else{
            $path = "/validasiProgress/validasiIRS/";
        }

        return redirect($path . "$angkatan/$mahasiswa->nim")->with('success', "Data IRS Semester $request->smt Berhasil Diubah!");
    }

    public function validateIRS(){
        if(request('validasi') == 1){
            IRS::where('nim', request('nim'))->where('smt', request('smt'))->update(['validasi' => 1]);
        }else{
            IRS::where('nim', request('nim'))->where('smt', request('smt'))->update(['validasi' => 0]);
        }

        return response()->json([
            'status' => 'success',
            'message' => request('validasi'),
        ]);
    }
}
