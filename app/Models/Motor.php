<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Motor extends Kendaraan
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $collection = 'motors';

    protected $fillable = [
        'id', 'mesin', 'tipe_asuransi', 'tipe_transmisi'
    ];
}
