<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
    protected $table = 'user';
    protected $primaryKey = 'u_account';
    public $incrementing = false;

    protected $fillable = [
        'u_name',
        'u_password',
    ];

    protected $hidden = [
        'u_password',
    ];
}
