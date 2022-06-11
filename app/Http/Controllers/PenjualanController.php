<?php

namespace App\Http\Controllers;

use App\Models\Stok;
use App\Models\Mobil;
use App\Models\Motor;
use App\Models\Kendaraan;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\PenjualanStokResource;

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

        // Cek stok
        $stok = Stok::where('id_kendaraan',$request->id_kendaraan)->first();

        if ($stok->jumlah < $request->jumlah) {
            return response()->json([
                'status' => 'Penjualan melebihi stok !',
                'stok' => $stok->jumlah,
            ], 400);
        }

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $session = DB::getMongoClient()->startSession();
        $session->startTransaction();

        try {
            $penjualan = Penjualan::create($request->all());

            $stok->update([
                'jumlah' => $stok->jumlah - $request->jumlah,
            ]);

            $session->commitTransaction();

        } catch (\Throwable $th) {
            $session->abortTransaction();
            
            return response()->json($th,400);

        }

        return response()->json($penjualan, 200);
    }
}
