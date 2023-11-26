<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class IRS extends Model
{
    use HasFactory;

    protected $table = "irs";
    // protected $primaryKey = ["smt", "nim"];
    protected $primaryKey = "nim";
    public $timestamps = false;
    public $incrementing = false;
    protected $guarded = [];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }

    static public function updateOrInsert($mahasiswa, $request, $validatedData){
        if (auth()->user()->level == "mahasiswa") {
            $mahasiswa = auth()->user()->mahasiswa;
        }
        
        if($request->scan_irs != null){
            $validatedData ["scan_irs"] = $request->file('scan_irs')->store('private/irs');
        }

        if($request->scan_irs_old == null){
            $validatedData['smt'] = $request->smt;
            $validatedData['nim'] = $mahasiswa->nim;
            $validatedData['validasi'] = 0;
            self::create($validatedData);
        }else{
            Storage::delete($request->scan_irs_old);
            self::where("smt", $request->smt)->where("nim",$mahasiswa->nim)->update($validatedData);
        }
    }
    
    public static function getSKSkList($data_nim){
        return self::whereIn('nim', $data_nim)->get()->groupBy('nim')->map(function($item) {
            return [
                'sksk' => $item->sum('sks'),
            ];
        });
    }

    public static function getRekapValidasiIRS($data_mhs){
        if(auth()->user()->level == "dosenwali"){
            $mhs_irs = self::selectRaw("angkatan, irs.nim, 
            COUNT(CASE WHEN validasi = 0 THEN 1 ELSE NULL END) as count_validasi_0")
            ->join("mahasiswa", "mahasiswa.nim", "=", "irs.nim")
            ->where("dosen_wali", auth()->user()->username)
            ->groupBy("angkatan", "irs.nim")
            ->get();
        }else{
            $mhs_irs = self::selectRaw("angkatan, irs.nim, 
            COUNT(CASE WHEN validasi = 0 THEN 1 ELSE NULL END) as count_validasi_0")
            ->join("mahasiswa", "mahasiswa.nim", "=", "irs.nim")
            ->groupBy("angkatan", "irs.nim")
            ->get();
        }

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

        return $rekap_irs;
    }

    public static function validateIRS($request){
        if($request == 1){
            IRS::where('nim', request('nim'))->where('smt', request('smt'))->update(['validasi' => 1]);
        }else{
            IRS::where('nim', request('nim'))->where('smt', request('smt'))->update(['validasi' => 0]);
        }
    }
}
