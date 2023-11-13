<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class UserImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{

    public $level = 0;
    public function __construct($level)
    {
        $this->level = $level;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model
    */
    public function model(array $row)
    {
        // dump($row);
        // dd('test');
        
        if (empty($row["nip"]) && empty($row["nim"])) {
            return null;
        }
        return new User([
            "username"=> $row["nim"] ?? $row['nip'],
            "password"=> Hash::make("password"),
            "level"=> $this->level,
            "status"=> 1,
        ]);
    }
}
