<?php 

namespace App\Repository;

use App\Models\Kendaraan;
use App\Models\Mobil;
use App\Models\Motor;
use App\Models\Penjualan;
use Illuminate\Support\Str;

interface KendaraanInterface
{
    public function createKendaraan($tahun, $warna, $harga);
    public function createMobil($kendaraan_id,$mesin, $kapasitas, $tipe);
    public function createMotor($kendaraan_id, $mesin, $suspensi, $transmisi);
    public function sellKendaraan($kendaraan_id, $trans_code, $kuantitas);
    public function fetchKendaraan();
    public function fetchMobil();
    public function fetchMotor();
    public function fetchOneKendaraan($id);
    public function fetchOnePenjualan($id);
}

class KendaraanRepository implements KendaraanInterface
{
    public function createKendaraan($tahun, $warna, $harga)
    {
        $uuid = Str::uuid()->toString();
        $data = Kendaraan::create([
            "uuid" => $uuid,
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
            "uuid" => $uuid,
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
            "uuid" => $uuid,
            "kendaraan_id" => $kendaraan_id,
            "mesin" => $mesin,
            "tipe_suspensi" => $suspensi,
            "tipe_transmisi" => $transmisi
        ]);

        return $data;
    }

    public function sellKendaraan($kendaraan_id, $trans_code, $kuantitas)
    {
        $uuid = Str::uuid()->toString();
        $data = Penjualan::create([
            'uuid' => $uuid,
            'kendaraan_id' => $kendaraan_id,
            'trans_code' => $trans_code,
            'kuantitas' => $kuantitas
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

    public function fetchOneKendaraan($id)
    {
        $data = Kendaraan::where('uuid', $id)->take(1)->get();

        return $data;
    }

    public function fetchOnePenjualan($id)
    {
        $data = Penjualan::where('uuid', $id)->take(1)->get();

        return $data;
    }

}