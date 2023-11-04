<?php

namespace App\Http\Controllers\DosenWali;

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
        $data_mhs = Mahasiswa::selectRaw("mahasiswa.angkatan, count(mahasiswa.angkatan) as jumlah_mhs")
        ->join("dosen_wali","dosen_wali.nip","=","mahasiswa.dosen_wali")
        ->where("dosen_wali.nip","=",auth()->user()->username)
        ->groupBy("mahasiswa.angkatan")
        ->get();

        return view("dosenwali.irs.index",[
            "data_mhs" => $data_mhs,
        ]);
    }

    public function listMhsAngkatan(String $angkatan)
    {
        $data_mhs = Mahasiswa::selectRaw("mahasiswa.nama, mahasiswa.nim, status, SUM(sks) as sksk")
        ->leftJoin("irs","irs.nim","=","mahasiswa.nim")
        ->where("dosen_wali","=",auth()->user()->username)
        ->where("angkatan","=",$angkatan)
        ->groupBy("mahasiswa.nama", "mahasiswa.nim", "status")->get();

        // dd($data_mhs);
        return view("dosenwali.irs.list_mhs",[
            "data_mhs"=> $data_mhs,
            "angkatan"=> $angkatan
        ]);
    }

    public function showIRSMhs($angkatan, $nim){
        $mahasiswa = Mahasiswa::where("nim","=",$nim)->first();
        $semesterInfo = $mahasiswa->calculateSemesterAndThnAjar();
        $semester = $semesterInfo['semester'];
        
        $dataIRS = $mahasiswa->getIRSArray($semester);
        // $smtIRSArray = $dataIRS['smtIRSArray'];
        $arrIRS = $dataIRS['arrIRS'];
        $SKSk = $dataIRS['SKSk'];

        // dump($SKSk);
        // // dump($smtIRSArray);
        // dd($arrIRS);

        return view('dosenwali.irs.show_irs', [
            'nim' => $nim,
            'irs' => $arrIRS,
            'semester' => $semester,
            // 'smtIRSArray' => $smtIRSArray,
            'SKSk' => $SKSk,
        ]);
    }

    public function validateIRS(){
        if(request('validasi') == 1){
            IRS::where('nim', '=', request('nim'))->where('smt', '=', request('smt'))->update(['validasi' => 1]);
        }else{
            IRS::where('nim', '=', request('nim'))->where('smt', '=', request('smt'))->update(['validasi' => 0]);
        }

        return response()->json([
            'status' => 'success',
            'message' => request('validasi'),
        ]);
    }

    public function show(IRS $iRS)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(IRS $iRS)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, IRS $iRS)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IRS $iRS)
    {
        //
    }
}
