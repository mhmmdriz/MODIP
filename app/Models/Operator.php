<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operator extends Model
{
    use HasFactory;

    protected $table = "operator";

    public function user()
    {
        return $this->hasOne(User::class, 'username', 'operator_id');
    }
}
