<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operator extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $primaryKey = "operator_id";
    protected $table = "operator";
    public $incrementing = false;

    public function user()
    {
        return $this->hasOne(User::class, 'username', 'operator_id');
    }
}
