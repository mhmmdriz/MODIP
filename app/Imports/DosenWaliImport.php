<?php

namespace App\Imports;

use App\Models\DosenWali;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;

class DosenWaliImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure, SkipsEmptyRows
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
        if($row["nip"] == null) {
            return null;
        } 
        return new DosenWali([
            "nip"=> $row["nip"],
            "nama"=> $row["nama"],
            "no_telp"=> $row["no_telp"],
            "email_sso"=> $row["email_sso"],
        ]);
    }

    public function rules(): array
    {
        return [
            'nama' => 'required',
            'no_telp' => 'required',
            'email_sso' => 'required',
        ];
    }
}
