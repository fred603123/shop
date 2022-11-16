<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $primaryKey = 'o_id';

    protected $fillable = [
        'u_account',
        'c_id',
    ];
}
