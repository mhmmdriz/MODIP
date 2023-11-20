<?php

namespace App\Http\Controllers\Operator;

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
        $data_mhs = Mahasiswa::get()->groupBy("angkatan")->map(function($item){
            return $item->count(); 
        });
        
        $mhs_irs = IRS::selectRaw("angkatan, irs.nim, 
        COUNT(CASE WHEN validasi = 0 THEN 1 ELSE NULL END) as count_validasi_0")
        ->join("mahasiswa", "mahasiswa.nim", "=", "irs.nim")
        ->groupBy("angkatan", "irs.nim")
        ->get();

        $rekap_irs = [];
        foreach($data_mhs as $angkatan => $jumlah){
            $rekap_irs[$angkatan] = [
                'sudah' => 0,
                'belum' => 0,
                'belum_entry'=> 0,
            ];
        }

        foreach($mhs_irs as $mhs){
            if($mhs->count_validasi_0 == 0){
                $rekap_irs[$mhs->angkatan]['sudah']++;
            }else{
                $rekap_irs[$mhs->angkatan]['belum']++;
            }
        }

        foreach($rekap_irs as $key => $value){
            $rekap_irs[$key]['belum_entry'] = $data_mhs[$key] - $value['sudah'] - $value['belum'];
        }

        return view("operator.validasi_progress_studi.irs.index",[
            "data_mhs" => $data_mhs,
            "rekap_irs" => $rekap_irs,
        ]);
    }

    public function listMhsAngkatan(String $angkatan)
    {
        $data_mhs = Mahasiswa::get()->where("angkatan", $angkatan);
        $data_nim = $data_mhs->pluck("nim");
        $data_irs = IRS::getSKSkList($data_nim);

        return view("operator.validasi_progress_studi.irs.list_mhs",[
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

        return view('operator.validasi_progress_studi.irs.show_irs', [
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

        return redirect("/validasiIRS/$angkatan/$mahasiswa->nim")->with('success', "Data IRS Semester $request->smt Berhasil Diubah!");
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
