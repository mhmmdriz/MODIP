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

    static public function updateOrInsert($request, $validatedData){
        $mahasiswa = auth()->user()->mahasiswa;
        
        $validatedData['nama'] = $mahasiswa->nama;
        if($request->scan_khs != null){
            $validatedData ["scan_khs"] = $request->file('scan_khs')->store('private/khs');
        }

        if($request->scan_khs_old == null){
            $validatedData['smt'] = $request->smt;
            $validatedData['nim'] = $mahasiswa->nim;
            $validatedData['validasi'] = 0;
            KHS::create($validatedData);
        }else{
            Storage::delete($request->scan_khs_old);
            KHS::where("smt", $request->smt)->where("nim",$mahasiswa->nim)->update($validatedData);
        }
    }
}
