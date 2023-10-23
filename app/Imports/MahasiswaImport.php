<?php

namespace App\Imports;

use App\Models\Mahasiswa;
use Maatwebsite\Excel\Concerns\ToModel;

class MahasiswaImport implements ToModel
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
            // "nim"=> $row["0"],
            // "nama"=> $row["1"],
            // "angkatan"=> $row["2"],
            // "status"=> $row["3"],
        ]);
    }
}
