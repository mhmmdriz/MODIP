<?php

namespace App\Exports;

// use App\Invoice;
use App\Models\Mahasiswa;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromQuery, WithHeadings
{
    use Exportable;

    public $angkatan = 0;
    public function __construct($angkatan)
    {
        $this->angkatan = $angkatan;
    }

    public function query()
    {
        if($this->angkatan == '') {
            // return Mahasiswa::query()->join('users', 'users.username', '=', 'nim')->orderBy('nim', 'asc');
            return Mahasiswa::query()->select("nim", "nama", "angkatan", "tahun_ajaran", "jalur_masuk", "status", "no_telp")->orderBy('nim', 'asc');
        }
        else {
            // return Mahasiswa::query()->where('angkatan', $this->angkatan)->join('users', 'users.username', '=', 'nim')->orderBy('nim', 'asc');
            return Mahasiswa::query()->select("nim", "nama", "angkatan", "tahun_ajaran", "jalur_masuk", "status", "no_telp")->where('angkatan', $this->angkatan)->orderBy('nim', 'asc');
        }
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function headings(): array
    {
        return ["nim", "nama", "angkatan", "tahun_ajaran", "jalur_masuk", "status", "no_telp"];
    }
}
