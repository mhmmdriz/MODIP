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
    protected $guarded = [];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }

    static public function updateOrInsert($request, $validatedData){
        $mahasiswa = auth()->user()->mahasiswa;
        
        $validatedData['nama'] = $mahasiswa->nama;
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
}
