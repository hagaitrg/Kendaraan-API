<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Penjualan extends Eloquent
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $collection = 'penjualans';

    protected $guarded = [];  
    protected $fillabel = [
        'uuid','kendaraan_id', 'trans_code','kuantitas'
    ];

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class, 'kendaraan_id');
    }
}
