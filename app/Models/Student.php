<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'msisdn',
        'full_name',
        'index_no',
        'code_id',
        'user_type'
    ];

    public function uuid()
    {
        return $this->belongsTo(Code::class, 'code_id');
    }
}
x
