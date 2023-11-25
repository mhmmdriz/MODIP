<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class UserImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure, SkipsEmptyRows
{
    use Importable;
    use SkipsFailures;

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

    public function rules(): array
    {
        return [
            'nip' => 'unique:users,username',
            'nim' => 'unique:users,username',
        ];
    }
    
}
