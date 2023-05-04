<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mobil extends Kendaraan
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $collection = 'mobils';

    protected $fillable = [
        'id', 'kendaraan_id','mesin', 'kapasitas_penumpang', 'tipe'
    ];

    public function kendaraan()
    {
        return $this->morphOne(Kendaraan::class, 'kendaraanParent');
    }
  
}
