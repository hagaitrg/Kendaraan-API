<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Motor extends Kendaraan
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $collection = 'motors';

    public $fillable = [
        'id','kendaraan_id','mesin', 'tipe_asuransi', 'tipe_transmisi'
    ];

    public function kendaraan()
    {
        return $this->morphOne(Kendaraan::class, 'kendaraanParent');
    }
}
