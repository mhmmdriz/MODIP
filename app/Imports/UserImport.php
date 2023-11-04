<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UserImport implements ToModel, WithHeadingRow
{

    public $level = 0;
    public function __construct($level)
    {
        $this->level = $level;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new User([
            "username"=> $row["nim"] ?? $row['nip'] ?? $row['departemen_id'],
            "password"=> Hash::make("password"),
            "level"=> $this->level,
            "status"=> 1,
        ]);
    }
}
