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

    static public function updateOrInsert($request, $validatedData){
        $mahasiswa = auth()->user()->mahasiswa;
        $nim = $mahasiswa->nim;
        $nama = $mahasiswa->nama;
        $validasi = 0;

        if ($request->status_old == null){
            $validatedData['nim'] = $nim;
            $validatedData['nama'] = $nama;
            $validatedData['status'] = "Lulus";
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

    public static function getRekapPKLAngkatan($data_mhs, $doswal = null){
        if($doswal == null){
            $mhs_pkl = PKL::selectRaw("mahasiswa.nim as mhs_nim, pkl.nim as pkl_nim, validasi, angkatan")
            ->join("mahasiswa", "mahasiswa.nim", "=", "pkl.nim")
            ->get();
        }else{
            $mhs_pkl = PKL::selectRaw("mahasiswa.nim as mhs_nim, pkl.nim as pkl_nim, validasi, angkatan")
            ->join("mahasiswa", "mahasiswa.nim", "=", "pkl.nim")
            ->where("dosen_wali", auth()->user()->username)
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
}
