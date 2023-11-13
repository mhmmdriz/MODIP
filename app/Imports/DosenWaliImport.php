<?php

namespace App\Imports;

use App\Models\DosenWali;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DosenWaliImport implements ToModel, WithHeadingRow
{
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
}
