<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = "mahasiswa";
    protected $primarykey = "nim";
    public $timestamps = false;
    protected $guarded = [];

    public function user()
    {
        return $this->hasOne(User::class, 'username', 'nim');
    }

    public function irs(){
        return $this->hasMany(IRS::class, 'nim', 'nim');
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
        if ($curr_date->month <= 6) {
            $smt = "Genap";
            $thn_ajar = strval($curr_year - 1) . '/' . strval($curr_year);
            $semester -= 1;
        } else {
            $smt = "Gasal";
            $thn_ajar = strval($curr_year) . '/' . strval($curr_year + 1);
        }

        return [
            'smt' => $smt,
            'thn_ajar' => $thn_ajar,
            'semester' => $semester,
        ];
    }

    public function getIRSArray($semester){
        $irs = $this->irs;
        $smtIrsArray = $irs->pluck('smt')->toArray();
        $arrIRS = [];

        $j = 0;
        for($i = 0; $i < $semester; $i++){
            if($smtIrsArray[$j] == $i + 1){
                $arrIRS[$i] = $irs->where('smt', $smtIrsArray[$j])->first();
                $j++;
            }else{
                $arrIRS[$i] = null;
            }
        }

        $SKSk = 0;
        foreach($irs as $i){
            $SKSk += $i->sks;
        }

        return [
            'arrIRS' => $arrIRS,
            'smtIrsArray' => $smtIrsArray,
            'SKSk' => $SKSk,
        ];

    }

}
