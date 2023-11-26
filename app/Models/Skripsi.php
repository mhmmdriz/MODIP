<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skripsi extends Model
{
    use HasFactory;

    protected $table = 'skripsi';
    protected $primaryKey = "nim";
    public $timestamps = false;
    public $incrementing = false;
    protected $guarded = [];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }

    static public function isEligible($dataKHS){
        $SKSk = 0;
        $n = 0;
        foreach($dataKHS as $khs){
            $SKSk += $khs->sks;
            $n++;
        }
        if ($SKSk >= 120){
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
            if($request->scan_bass != null){
                $validatedData ["scan_bass"] = $request->file('scan_bass')->store('private/skripsi');
            }
            self::create($validatedData);
        }
        else {
            if($request->scan_bass != null){
                Storage::delete($request->scan_bass_old);
                $validatedData ["scan_bass"] = $request->file('scan_bass')->store('private/skripsi');
            }
            self::where("nim", $nim)->update($validatedData);
        }
    }

    public static function getRekapValidasiSkripsi($data_mhs, $doswal = null){
        if(auth()->user()->level == "dosenwali"){
            $mhs_skripsi = self::selectRaw("mahasiswa.nim as mhs_nim, skripsi.nim as skripsi_nim, validasi, angkatan")
            ->join("mahasiswa", "mahasiswa.nim", "=", "skripsi.nim")
            ->where("dosen_wali", auth()->user()->username)
            ->get();
        }else{
            $mhs_skripsi = self::selectRaw("mahasiswa.nim as mhs_nim, skripsi.nim as skripsi_nim, validasi, angkatan")
            ->join("mahasiswa", "mahasiswa.nim", "=", "skripsi.nim")
            ->get();
        }

        $rekap_skripsi = [];
        foreach($data_mhs as $angkatan => $jumlah){
            $rekap_skripsi[$angkatan] = [
                'sudah' => 0,
                'belum' => 0,
                'belum_entry'=> 0,
            ];
        }

        foreach($mhs_skripsi as $mhs){
            if($mhs->validasi == 1){
                $rekap_skripsi[$mhs->angkatan]['sudah']++;
            }else{
                $rekap_skripsi[$mhs->angkatan]['belum']++;
            }
        }

        foreach($rekap_skripsi as $key => $value){
            $rekap_skripsi[$key]['belum_entry'] = $data_mhs[$key] - $value['sudah'] - $value['belum'];
        }

        return $rekap_skripsi;
    }

    public static function getRekapSkripsi(){
        if(auth()->user()->level == "dosenwali"){
            $mhs_skripsi = self::selectRaw("mahasiswa.nim as mhs_nim, skripsi.nim as skripsi_nim, validasi, angkatan")
            ->rightJoin("mahasiswa", "mahasiswa.nim", "=", "skripsi.nim")
            ->where("dosen_wali", auth()->user()->username)
            ->get();
        }else{
            $mhs_skripsi = self::selectRaw("mahasiswa.nim as mhs_nim, skripsi.nim as skripsi_nim, validasi, angkatan")
            ->rightJoin("mahasiswa", "mahasiswa.nim", "=", "skripsi.nim")
            ->get();
        }

        $rekap_skripsi = $mhs_skripsi->pluck('angkatan')->unique()->mapWithKeys(function ($angkatan) {
            return [$angkatan => [
                'sudah_skripsi' => 0,
                'belum_skripsi' => 0,
            ]];
        })->all();

        foreach($mhs_skripsi as $mhs){
            if($mhs->validasi == 1){
                $rekap_skripsi[$mhs->angkatan]['sudah_skripsi']++;
            }else{
                $rekap_skripsi[$mhs->angkatan]['belum_skripsi']++;
            }
        }

        return $rekap_skripsi;
    }

    public static function getListRekapMhsSkripsi($request){
        if($request->status == "Sudah"){
            $data_mhs = self::join("mahasiswa","mahasiswa.nim","=", "skripsi.nim")->where("angkatan", $request->angkatan)
            ->where("validasi", 1);
        }else{
            $data_mhs = self::Rightjoin("mahasiswa","mahasiswa.nim","=", "skripsi.nim")->where("angkatan", $request->angkatan)
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

    public static function validateSkripsi($mahasiswa, $validate){
        self::where('nim', '=', $mahasiswa->nim)->update(['validasi' => $validate]);
    }
}
