<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KHS extends Model
{
    use HasFactory;

    protected $table = "khs";
    // protected $primarykey = ["smt", "nim"];
    protected $primaryKey = "nim";
    public $timestamps = false;
    public $incrementing = false;
    protected $guarded = [];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }

    static public function rekapKHS($arrKHS){
        $SKSk = 0;
        $IPk = 0;
        $n = 0;

        foreach($arrKHS as $khs){
            $SKSk += $khs->sks;
            $IPk += $khs->ips;
            $n++;
        }
        if ($n != 0){
            $IPk = $IPk/$n;
        }

        return [
            'SKSk' => $SKSk,
            'IPk' => $IPk,
        ];
    }

    static public function updateOrInsert($mahasiswa, $request, $validatedData){
        if (auth()->user()->level == "mahasiswa") {
            $mahasiswa = auth()->user()->mahasiswa;
        }
        
        if($request->scan_khs != null){
            $validatedData ["scan_khs"] = $request->file('scan_khs')->store('private/khs');
        }

        if($request->scan_khs_old == null){
            $validatedData['smt'] = $request->smt;
            $validatedData['nim'] = $mahasiswa->nim;
            $validatedData['validasi'] = 0;
            self::create($validatedData);
        }else{
            Storage::delete($request->scan_khs_old);
            self::where("smt", $request->smt)->where("nim",$mahasiswa->nim)->update($validatedData);
        }
    }
    
    public static function getSKSkIPkList($data_nim){
        return self::whereIn('nim', $data_nim)->get()->groupBy('nim')->map(function($item) {
            return [
                'sksk' => $item->sum('sks'),
                'ipk' => $item->avg('ips'),
            ];
        });
    }

    public static function getRekapValidasiKHS($data_mhs){
        if(auth()->user()->level == "dosenwali"){
            $mhs_khs = self::selectRaw("angkatan, khs.nim, 
            COUNT(CASE WHEN validasi = 0 THEN 1 ELSE NULL END) as count_validasi_0")
            ->join("mahasiswa", "mahasiswa.nim", "=", "khs.nim")
            ->where("dosen_wali", auth()->user()->username)
            ->groupBy("angkatan", "khs.nim")
            ->get();
        }else{
            $mhs_khs = self::selectRaw("angkatan, khs.nim, 
            COUNT(CASE WHEN validasi = 0 THEN 1 ELSE NULL END) as count_validasi_0")
            ->join("mahasiswa", "mahasiswa.nim", "=", "khs.nim")
            ->groupBy("angkatan", "khs.nim")
            ->get();
        }

        $rekap_khs = [];
        foreach($data_mhs as $angkatan => $jumlah){
            $rekap_khs[$angkatan] = [
                'sudah' => 0,
                'belum' => 0,
                'belum_entry'=> 0,
            ];
        }

        foreach($mhs_khs as $mhs){
            if($mhs->count_validasi_0 == 0){
                $rekap_khs[$mhs->angkatan]['sudah']++;
            }else{
                $rekap_khs[$mhs->angkatan]['belum']++;
            }
        }

        foreach($rekap_khs as $key => $value){
            $rekap_khs[$key]['belum_entry'] = $data_mhs[$key] - $value['sudah'] - $value['belum'];
        }

        return $rekap_khs;
    }

    public static function validateKHS($request){
        if($request == 1){
            self::where('nim', request('nim'))->where('smt', request('smt'))->update(['validasi' => 1]);
        }else{
            self::where('nim', request('nim'))->where('smt', request('smt'))->update(['validasi' => 0]);
        }
    }
}
