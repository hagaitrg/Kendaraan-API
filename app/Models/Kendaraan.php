<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Kendaraan extends Eloquent
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $collection = 'kendaraans';

    protected $guarded = [];  
    protected $fillabel = [
        'id','tahun_keluaran', 'warna','harga'
    ];

    public function kendaraanParent()
    {
        return $this->morphTo();
    }
}
