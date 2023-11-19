<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = "mahasiswa";
    protected $primaryKey = "nim";
    public $timestamps = false;
    protected $guarded = [];

    public function user()
    {
        return $this->hasOne(User::class, 'username', 'nim');
    }

    public function irs(){
        return $this->hasMany(IRS::class, 'nim', 'nim');
    }

    public function khs(){
        return $this->hasMany(KHS::class, 'nim', 'nim');
    }

    public function pkl()
    {
        return $this->hasOne(PKL::class, 'nim', 'nim');
    }
    
    public function skripsi()
    {
        return $this->hasOne(Skripsi::class, 'nim', 'nim');
    }

    public function dosenwali(){
        return $this->belongsTo(DosenWali::class, 'dosen_wali', 'nip');
    }

    public function getRouteKeyName()
    {
        return 'nim';
    }

    public function calculateSemesterAndThnAjar()
    {
        $curr_date = Carbon::now()->setTimezone('Asia/Jakarta');
        $curr_year = $curr_date->year;
        $angkatan = $this->angkatan;
        $semester = ($curr_year - $angkatan) * 2 + 1;

        if ($curr_date->gt(Carbon::createFromDate($curr_date->year, 2, 15)) && $curr_date->lt(Carbon::createFromDate($curr_date->year, 8, 16))) {
            $smt = "Genap";
            $thn_ajar = strval($curr_year - 1) . '/' . strval($curr_year);
            $semester -= 1;
        } else if($curr_date->gt(Carbon::createFromDate($curr_date->year, 8, 15)) || $curr_date->lt(Carbon::createFromDate($curr_date->year, 2, 16))) {
            $smt = "Gasal";
            $thn_ajar = strval($curr_year) . '/' . strval($curr_year + 1);
        }
        if ($curr_date->lte(Carbon::createFromDate($curr_date->year, 2, 15))) {
            $smt = "Gasal";
            $thn_ajar = strval($curr_year) . '/' . strval($curr_year + 1);
            $semester -= 2;
        }

        return [
            'smt' => $smt,
            'thn_ajar' => $thn_ajar,
            'semester' => $semester,
        ];
    }

    public function getIRSArray($semester){
        $irs = $this->irs;
        $smtIRSArray = $irs->pluck('smt')->toArray();
        $arrIRS = [];
        $j = 0;
        // dd($smtIrsArray);
        if(!empty($smtIRSArray)){
            for($i = 0; $i < $semester; $i++){
                if($j <= count($smtIRSArray)-1){
                    if($smtIRSArray[$j] == $i + 1){
                        $arrIRS[$i] = $irs->where('smt', $smtIRSArray[$j])->first();
                        $j++;
                    }
                    else{
                        $arrIRS[$i] = null;
                    }
                }
                else{
                    $arrIRS[$i] = null;
                }
            }
        }else{
            for($i = 0; $i < $semester; $i++){
                $arrIRS[$i] = null;
            }
        }

        $SKSk = 0;
        foreach($irs as $i){
            $SKSk += $i->sks;
        }
        // dd($smt);
        return [
            'arrIRS' => $arrIRS,
            // 'smtIRSArray' => $smtIRSArray,
            'SKSk' => $SKSk,
        ];

    }

    public function getKHSArray($semester){
        $khs = $this->khs;
        $smtKHSArray = $khs->pluck('smt')->toArray();
        $arrKHS = [];
        $j = 0;
        
        if(!empty($smtKHSArray)){
            for($i = 0; $i < $semester; $i++){
                if($j <= count($smtKHSArray)-1){
                    if($smtKHSArray[$j] == $i + 1){
                        $arrKHS[$i] = $khs->where('smt', $smtKHSArray[$j])->first();
                        $j++;
                    }
                    else{
                        $arrKHS[$i] = null;
                    }
                }
                else{
                    $arrKHS[$i] = null;
                }
            }
        }else{
            for($i = 0; $i < $semester; $i++){
                $arrKHS[$i] = null;
            }
        }

        $SKSk = 0;
        foreach($khs as $k){
            $SKSk += $k->sks;
        }
        
        return [
            'arrKHS' => $arrKHS,
            // 'smtKHSArray' => $smtKHSArray,
            'SKSk' => $SKSk,
        ];

    }

    static public function getAngkatan($data_mhs){
        $data_angkatan = $data_mhs->pluck('angkatan')->unique()->values();
        return $data_angkatan;
    }

    
}
