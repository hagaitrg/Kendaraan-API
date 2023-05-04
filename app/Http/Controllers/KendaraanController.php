<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Repository\KendaraanRepository;
use App\Repository\ResponseRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KendaraanController extends Controller
{
    private $kendaraan, $res;

    public function __construct(KendaraanRepository $kendaraan, ResponseRepository $res)
    {
        $this->kendaraan = $kendaraan;
        $this->res = $res;
    }

    public function stockKendaraan()
    {
        try {
            $data = [
                'kendaraan'=> $this->kendaraan->fetchKendaraan(),
                'mobil' => $this->kendaraan->fetchMobil(),
                'motor' => $this->kendaraan->fetchMotor()
            ];
            return $this->res->sendSuccess(200, 'Successfully fetch all kendaraan', $data);
        } catch (\Throwable $th) {
           return $this->res->sendError(500, 'Failde fetc all kendaraan', $th->getMessage());
        }
        
    }

    public function storeMobil(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tahun_keluaran' => 'required|string',
            'warna' => 'required|string',
            'harga' => 'required|integer',
            'mesin' => 'required|string',
            'kapasitas_penumpang' => 'required|integer',
            'tipe' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->res->sendError(400, $validator->errors(), null);
        }

        try {
            $kendaraan = $this->kendaraan->createKendaraan($request->tahun_keluaran, $request->warna, $request->harga);
            $mobil = $this->kendaraan->createMobil($kendaraan->id, $request->mesin, $request->kapasitas_penumpang, $request->tipe);
            return $this->res->sendSuccess(200, 'Mobil created successfully', [$kendaraan, $mobil]);
        } catch (\Throwable $th) {
            return $this->res->sendError(500, 'Failed to create mobil', $th->getMessage());
        }
    }

    public function storeMotor(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tahun_keluaran' => 'required|string',
            'warna' => 'required|string',
            'harga' => 'required|integer',
            'mesin' => 'required|string',
            'tipe_suspensi' => 'required|string',
            'tipe_transmisi' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->res->sendError(400, $validator->errors(), null);
        }

        try {
            $kendaraan = $this->kendaraan->createKendaraan($request->tahun_keluaran, $request->warna, $request->harga);
            $motor = $this->kendaraan->createMotor($kendaraan->id, $request->mesin, $request->tipe_suspensi, $request->tipe_transmisi);
            return $this->res->sendSuccess(200, 'Motor created successfully', [$kendaraan, $motor]);
        } catch (\Throwable $th) {
            return $this->res->sendError(500, 'Failed to create mobil', $th->getMessage());
        }
    }

    public function penjualan(Request $request, $kendaraanId)
    {
        $validator = Validator::make($request->all(), [
            'kuantitas' => 'required|integer',
            'amount' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return $this->res->sendError(400, $validator->errors(), null);
        }

        $checkKendaraan = $this->kendaraan->fetchOneKendaraan($kendaraanId);
        if (!$checkKendaraan) {
            return $this->res->sendError(404, "Kendaraan not found!", null);
        }

        if ($request->amount < $checkKendaraan[0]->harga) {
            return $this->res->sendError(400, "Unable to buy kendaraan", null);
        }

        try {
            $data = $this->kendaraan->sellKendaraan($kendaraanId, $this->generateTransCode($kendaraanId), $request->kuantitas);
            return $this->res->sendSuccess(200, 'Successfully sell Kendaraan', $data);
        } catch (\Throwable $th) {
            return $this->res->sendError(500, 'Failed to sell kendaraan', $th->getMessage());
        }

    }

    protected function generateTransCode($kendaraanId)
    {
        $transCode = "TR-".Carbon::now()->format('Ymd')."-".substr($kendaraanId, -4);

        return $transCode;
    }
}
