<?php

namespace App\Http\Controllers;

use App\Http\Resources\PenjualanResource;
use App\Http\Resources\PenjualanStokResource;
use App\Models\Kendaraan;
use App\Models\Mobil;
use App\Models\Motor;
use Illuminate\Support\Facades\Validator;
use App\Models\Penjualan;
use Illuminate\Http\Request;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Penjualan::with([
            'kendaraan'
        ])->get();

    return PenjualanStokResource::collection($data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_kendaraan' => 'required|exists:kendaraan,_id',
            'jumlah' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $penjualan = Penjualan::create($request->all());

        return response()->json($penjualan, 200);
    }
}
