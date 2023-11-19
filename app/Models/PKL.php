<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PKL extends Model
{
    use HasFactory;

    protected $table = 'pkl';
    protected $primarykey = "nim";
    public $timestamps = false;
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
        if ($SKSk >= 100){
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
}
