<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mobil extends Model
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $collection = 'mobils';

    protected $fillable = [
        'id', 'mesin', 'kapasitas_penumpang', 'tipe'
    ];
}
