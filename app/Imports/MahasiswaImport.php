<?php

namespace App\Imports;

use App\Models\Mahasiswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithValidation;
use App\Events\ExcelRowImported;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;

class MahasiswaImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure, SkipsEmptyRows
{
    use Importable;
    use SkipsFailures;

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if($row["nim"] == null) {
            return null;
        } 
        return new Mahasiswa([
            "nim"=> $row["nim"],
            "nama"=> $row["nama"],
            "angkatan"=> $row["angkatan"],
            "status"=> $row["status"],
            "dosen_wali"=> $row["dosen_wali"],
        ]);
    }

    public function rules(): array
    {
        return [
            'nama' => 'required',
            'angkatan' => 'required',
            'status' => 'required',
            'dosen_wali' => 'required',
        ];
    }
}
