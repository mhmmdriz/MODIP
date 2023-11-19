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
            if($request->scan_bass != null){
                $validatedData ["scan_bass"] = $request->file('scan_bass')->store('private/skripsi');
            }
            Skripsi::create($validatedData);
        }
        else {
            $validatedData['status'] = "Lulus";
            if($request->scan_bass != null){
                Storage::delete($request->scan_bass_old);
                $validatedData ["scan_bass"] = $request->file('scan_bass')->store('private/skripsi');
            }
            Skripsi::where("nim", $nim)->update($validatedData);
        }
    }
}
