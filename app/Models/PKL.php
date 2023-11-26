<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PKL extends Model
{
    use HasFactory;

    protected $table = 'pkl';
    protected $primaryKey = "nim";
    public $timestamps = false;
    public $incrementing = false;
    protected $guarded = [];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }

    static public function isEligible($semester){
        if ($semester >= 6){
            $is_eligible = True;
        } else {
            $is_eligible = False;
        }

        return $is_eligible;
    }

    static public function updateOrInsert($mahasiswa, $request, $validatedData){
        if (auth()->user()->level == "mahasiswa") {
            $mahasiswa = auth()->user()->mahasiswa;
        }
        
        $nim = $mahasiswa->nim;
        $validasi = 0;

        if ($request->status_old == null){
            $validatedData['nim'] = $nim;
            $validatedData['validasi'] = $validasi;
            if($request->scan_basp != null){
                $validatedData ["scan_basp"] = $request->file('scan_basp')->store('private/pkl');
            }
            self::create($validatedData);
        }
        else {
            if($request->scan_basp != null){
                Storage::delete($request->scan_basp_old);
                $validatedData ["scan_basp"] = $request->file('scan_basp')->store('private/pkl');
            }
            self::where("nim", $nim)->update($validatedData);
        }
    }

    public static function getRekapValidasiPKL($data_mhs){
        if(auth()->user()->level == "dosenwali"){
            $mhs_pkl = self::selectRaw("mahasiswa.nim as mhs_nim, pkl.nim as pkl_nim, validasi, angkatan")
            ->join("mahasiswa", "mahasiswa.nim", "=", "pkl.nim")
            ->where("dosen_wali", auth()->user()->username)
            ->get();
        }else{
            $mhs_pkl = self::selectRaw("mahasiswa.nim as mhs_nim, pkl.nim as pkl_nim, validasi, angkatan")
            ->join("mahasiswa", "mahasiswa.nim", "=", "pkl.nim")
            ->get();
        }

        $rekap_pkl = [];
        foreach($data_mhs as $angkatan => $jumlah){
            $rekap_pkl[$angkatan] = [
                'sudah' => 0,
                'belum' => 0,
                'belum_entry'=> 0,
            ];
        }

        foreach($mhs_pkl as $mhs){
            if($mhs->validasi == 1){
                $rekap_pkl[$mhs->angkatan]['sudah']++;
            }else{
                $rekap_pkl[$mhs->angkatan]['belum']++;
            }
        }

        foreach($rekap_pkl as $key => $value){
            $rekap_pkl[$key]['belum_entry'] = $data_mhs[$key] - $value['sudah'] - $value['belum'];
        }

        return $rekap_pkl;
    }

    public static function getRekapPKL(){
        if(auth()->user()->level == "dosenwali"){
            $mhs_pkl = self::selectRaw("mahasiswa.nim as mhs_nim, pkl.nim as pkl_nim, validasi, angkatan")
            ->rightJoin("mahasiswa", "mahasiswa.nim", "=", "pkl.nim")
            ->where("dosen_wali", auth()->user()->username)
            ->get();
        }else{
            $mhs_pkl = self::selectRaw("mahasiswa.nim as mhs_nim, pkl.nim as pkl_nim, validasi, angkatan")
            ->rightJoin("mahasiswa", "mahasiswa.nim", "=", "pkl.nim")
            ->get();
        }

        $rekap_pkl = $mhs_pkl->pluck('angkatan')->unique()->mapWithKeys(function ($angkatan) {
            return [$angkatan => [
                'sudah_pkl' => 0,
                'belum_pkl' => 0,
            ]];
        })->all();

        foreach($mhs_pkl as $mhs){
            if($mhs->validasi == 1){
                $rekap_pkl[$mhs->angkatan]['sudah_pkl']++;
            }else{
                $rekap_pkl[$mhs->angkatan]['belum_pkl']++;
            }
        }

        return $rekap_pkl;
    }

    public static function getListRekapMhsPKL($request){
        if($request->status == "Sudah"){
            $data_mhs = self::join("mahasiswa","mahasiswa.nim","=", "pkl.nim")->where("angkatan", $request->angkatan)
            ->where("validasi", 1);
        }else{
            $data_mhs = self::Rightjoin("mahasiswa","mahasiswa.nim","=", "pkl.nim")->where("angkatan", $request->angkatan)
            ->where(function($query) {
                $query->where('validasi', 0)
                      ->orWhereNull('validasi');
            });
        }

        if(auth()->user()->level == "dosenwali"){
            $data_mhs = $data_mhs->where("dosen_wali", auth()->user()->username);
        }

        $data_mhs = $data_mhs->get();

        return $data_mhs;
    }

    public static function validatePKL($mahasiswa, $validate){
        self::where('nim', '=', $mahasiswa->nim)->update(['validasi' => $validate]);
    }
    
}
