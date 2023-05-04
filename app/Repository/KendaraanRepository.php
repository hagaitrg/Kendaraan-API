<?php 

namespace App\Repository;

use App\Models\Kendaraan;
use App\Models\Mobil;
use App\Models\Motor;
use Illuminate\Support\Str;

interface KendaraanInterface
{
    public function createKendaraan($tahun, $warna, $harga);
    public function createMobil($kendaraan_id,$mesin, $kapasitas, $tipe);
    public function createMotor($kendaraan_id, $mesin, $suspensi, $transmisi);
    public function fetchKendaraan();
    public function fetchMobil();
    public function fetchMotor();
}

class KendaraanRepository implements KendaraanInterface
{
    public function createKendaraan($tahun, $warna, $harga)
    {
        $uuid = Str::uuid()->toString();
        $data = Kendaraan::create([
            "id" => $uuid,
            "tahun_keluaran" => $tahun,
            "warna" => $warna,
            "harga" => $harga
        ]);

        return $data;
    }

    public function createMobil($kendaraan_id,$mesin, $kapasitas, $tipe)
    {
        $uuid = Str::uuid()->toString();
        $data = Mobil::create([
            "id" => $uuid,
            "kendaraan_id" => $kendaraan_id,
            "mesin" => $mesin,
            "kapasitas_penumpang" => $kapasitas,
            "tipe" => $tipe
        ]);

        return $data;
    }

    public function createMotor($kendaraan_id, $mesin, $suspensi, $transmisi)
    {
        $uuid = Str::uuid()->toString();
        $data = Motor::create([
            "id" => $uuid,
            "kendaraan_id" => $kendaraan_id,
            "mesin" => $mesin,
            "tipe_suspensi" => $suspensi,
            "tipe_transmisi" => $transmisi
        ]);

        return $data;
    }

    public function fetchKendaraan()
    {
        $data = Kendaraan::all();

        return $data;
    }

    public function fetchMobil()
    {
        $data = Mobil::all();
        return $data;
    }

    public function fetchMotor()
    {
        $data = Motor::all();
        return $data;
    }

}