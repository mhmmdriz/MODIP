<?php

namespace App\Http\Controllers;

use App\Models\PKL;
use App\Http\Requests\StorePKLRequest;
use App\Http\Requests\UpdatePKLRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class PKLController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mahasiswa = auth()->user()->mahasiswa;
        $dataPKL = $mahasiswa->pkl;

        return view('mahasiswa.pkl.index', [
            'dataPKL' => $dataPKL,
        ]);
    }

    public function updateOrInsert(Request $request)
    {
        // dd($request->all());
        $status = $request->status;
        $mahasiswa = auth()->user()->mahasiswa;
        $nim = $mahasiswa->nim;
        $nama = $mahasiswa->nama;
        $validasi = 0;
        // dd($request->status_old);
        if ($status == ""){
            return redirect('/pkl');
        }
        if ($request->status_old == null){
            if ($status == "Belum Ambil"){
                PKL::create(['nim' => $nim, 'nama' => $nama, 'status' => $status, 'validasi' => $validasi]);
            } else if ($status == "Sedang Ambil") {
                PKL::create(['nim' => $nim, 'nama' => $nama, 'status' => $status, 'validasi' => $validasi]);
            } else {
                $rules = [ 
                    'tanggal_seminar' => 'required',
                    'nilai' => 'required',
                ];
                if ($request->scan_basp_old == null) {
                    $rules['scan_basp'] = 'required|mimes:pdf|max:10000';
                }else{
                    Storage::delete($request->scan_basp_old);
                }
                
                $tgl_seminar = Carbon::parse($request->tanggal_seminar);
                $semester = ($tgl_seminar->year - $mahasiswa->angkatan) * 2 + 1;
                if ($tgl_seminar->gt(Carbon::createFromDate($tgl_seminar->year, 2, 15)) && $tgl_seminar->lte(Carbon::createFromDate($tgl_seminar->year, 8, 15))) {
                    $semester -= 1;
                } else if ($tgl_seminar->lte(Carbon::createFromDate($tgl_seminar->year, 2, 15))) {
                    $semester -= 2;
                }
                $validatedData = $request->validate($rules);
                if($request->scan_basp != null){
                    $validatedData ["scan_basp"] = $request->file('scan_basp')->store('private/pkl');
                }
                $validatedData['semester'] = $semester;
                $validatedData['nim'] = $nim;
                $validatedData['nama'] = $nama;
                $validatedData['status'] = $status;
                $validatedData['validasi'] = $validasi;
                // dd($semester);
                PKL::create($validatedData);
            }
        } else {
            if ($status == "Belum Ambil"){
                PKL::where("nim", $nim)->update(['status' => $status, 'semester' => null, 'tanggal_seminar' => null, 'nilai' => null, 'scan_basp' => null]);
                if ($request->scan_basp_old != null) {
                    Storage::delete($request->scan_basp_old);
                }
            } else if ($status == "Sedang Ambil") {
                PKL::where("nim", $nim)->update(['status' => $status, 'semester' => null, 'tanggal_seminar' => null, 'nilai' => null, 'scan_basp' => null]);
                if ($request->scan_basp_old != null) {
                    Storage::delete($request->scan_basp_old);
                }
            } else {
                $rules = [ 
                    'tanggal_seminar' => 'required',
                    'nilai' => 'required',
                ];
                if ($request->scan_basp_old == null) {
                    $rules['scan_basp'] = 'required|mimes:pdf|max:10000';
                }else{
                    Storage::delete($request->scan_basp_old);
                }
                
                $tgl_seminar = Carbon::parse($request->tanggal_seminar);
                $semester = ($tgl_seminar->year - $mahasiswa->angkatan) * 2 + 1;
                if ($tgl_seminar->gt(Carbon::createFromDate($tgl_seminar->year, 2, 15)) && $tgl_seminar->lte(Carbon::createFromDate($tgl_seminar->year, 8, 15))) {
                    $semester -= 1;
                } else if ($tgl_seminar->lte(Carbon::createFromDate($tgl_seminar->year, 2, 15))) {
                    $semester -= 2;
                }
                $validatedData = $request->validate($rules);
                if($request->scan_basp != null){
                    $validatedData ["scan_basp"] = $request->file('scan_basp')->store('private/pkl');
                }
                $validatedData['semester'] = $semester;
                // $validatedData['nim'] = $nim; 1
                // $validatedData['nama'] = $nama; 2
                $validatedData['status'] = $status;
                // $validatedData['validasi'] = $validasi; 3
                // dd($semester);
                PKL::where("nim", $nim)->update($validatedData);
            }
            
        }
        return redirect('/pkl')->with('success', "Data PKL Berhasil Diubah!");
    }
}
