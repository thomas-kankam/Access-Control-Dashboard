<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'msisdn',
        'network',
        'full_name',
        'user_type',
        'index_no',
        'code_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
