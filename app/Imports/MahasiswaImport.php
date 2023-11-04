<?php

namespace App\Imports;

use App\Models\Mahasiswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MahasiswaImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Mahasiswa([
            "nim"=> $row["nim"],
            "nama"=> $row["nama"],
            "angkatan"=> $row["angkatan"],
            "status"=> $row["status"],
            "dosen_wali"=> $row["dosen_wali"],
        ]);
    }
}
