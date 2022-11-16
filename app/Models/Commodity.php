<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commodity extends Model
{
    use HasFactory;
    protected $table = 'commodity';
    protected $primaryKey = 'c_id';

    protected $fillable = [
        'c_name',
        'c_price',
    ];
}
