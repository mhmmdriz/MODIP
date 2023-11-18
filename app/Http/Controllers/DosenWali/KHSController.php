<?php

namespace App\Http\Controllers\DosenWali;

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
        // dd($data_mhs);

        return view("dosenwali.khs.index",[
            "data_mhs" => $data_mhs,
        ]);
    }

    public function listMhsAngkatan(String $angkatan)
    {
        $data_mhs = Mahasiswa::get()->where("dosen_wali", auth()->user()->username)->where("angkatan", $angkatan);

        $data_khs = KHS::get()->groupBy('nim')->map(function($item) {
            return [
                'sksk' => $item->sum('sks'),
                'ipk' => $item->avg('ips'),
        ];
        });
        // dd($data_khs);
        
        return view("dosenwali.khs.list_mhs",[
            "data_mhs"=> $data_mhs,
            "data_khs"=> $data_khs,
            "angkatan"=> $angkatan,
        ]);
    }

    // public function showKHSMhs($angkatan, $nim){
    //     $mahasiswa = Mahasiswa::where("nim", $nim)->first();
    //     $semesterInfo = $mahasiswa->calculateSemesterAndThnAjar();
    //     $semester = $semesterInfo['semester'];
        
    //     $dataKHS = KHS::get()->where('nim', $nim);
    //     $SKSk = $dataKHS->sum('sks');
    //     $IPk = $dataKHS->avg('ips');
    //     dd($dataKHS);
        
    //     return view('dosenwali.khs.show_khs', [
    //         'nim' => $nim,
    //         'dataKHS' => $dataKHS,
    //         'SKSk' => $SKSk,
    //         'IPk' => $IPk,
    //         'semester' => $semester,
    //     ]);
    // }

    public function showKHSMhs($angkatan, $nim){
        $mahasiswa = Mahasiswa::where("nim","=",$nim)->first();
        $semesterInfo = $mahasiswa->calculateSemesterAndThnAjar();
        $semester = $semesterInfo['semester'];

        $arrKHS = $mahasiswa->khs;

        $SKSk = 0;
        $IPk = 0;
        $n = 0;
        foreach($arrKHS as $khs){
            $SKSk += $khs->sks;
            $IPk += $khs->ips;
            $n++;
        }
        $IPk = $IPk/$n;

        return view('dosenwali.khs.show_khs', [
            'nim' => $nim,
            'nama' => $mahasiswa->nama,
            'khs' => $arrKHS,
            'semester' => $semester,
            'SKSk' => $SKSk,
            'IPk' => $IPk,
            'angkatan' => $angkatan,
        ]);
    }

    public function updateKHSMhs($angkatan, $nim, Request $request){
        $validated_data = $request->validate([
            'sks' => 'required',
            'ips' => 'required',
        ]);

        KHS::where('nim','=',$nim)->where('smt', '=', $request->smt)->update($validated_data);

        return redirect("/khsPerwalian/$angkatan/$nim")->with('success', "Data KHS Semester $request->smt Berhasil Diubah!");
    }

    // public function validateKHS(){
    //     if(request('validasi') == 1){
    //         KHS::where('nim', '=', request('nim'))->where('smt', '=', request('smt'))->update(['validasi' => 1]);
    //     }else{
    //         KHS::where('nim', '=', request('nim'))->where('smt', '=', request('smt'))->update(['validasi' => 0]);
    //     }

    //     return response()->json([
    //         'status' => 'success',
    //         'message' => request('validasi'),
    //     ]);
    // }

    //     public function validateKHS()
    // {
    //     $nim = request('nim');
    //     $smt = request('smt');
    //     $lockStatus = request('validasi') == 1 ? 1 : 0;

    //     KHS::where('nim', $nim)->where('smt', $smt)->update(['validasi' => 1]);

    //     // Set a session variable to indicate that the KHS is now locked
    //     session(["khsLocked_$smt" => $lockStatus]);

    //     return response()->json([
    //         'status' => 'success',
    //         'message' => request('validasi'),
    //     ]);
    // }

        public function validateKHS()
    {
        $status = request('validasi') == 1 ? 'success' : 'failed';

        if(request('validasi') == 1){
            KHS::where('nim', '=', request('nim'))->where('smt', '=', request('smt'))->update(['validasi' => 1, 'locked' => 1]);
        } else {
            KHS::where('nim', '=', request('nim'))->where('smt', '=', request('smt'))->update(['validasi' => 0]);
        }

        return response()->json([
            'status' => $status,
            'message' => request('validasi'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
