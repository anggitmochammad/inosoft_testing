<?php

namespace App\Http\Controllers;

use App\Models\Stok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\PenjualanStokResource;

class StokController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Stok::with([
            'kendaraan',
        ])->get();

        return PenjualanStokResource::collection($data);

    }
    
    public function store(Request $request)
    {
        return response('cok');

        $validator = Validator::make($request->all(), [
            'id_kendaraan' => 'required|exists:kendaraan,_id',
            'jumlah' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $stok = Stok::create($request->all());

        return response()->json($stok, 200);
    }

    public function update(Request $request,Stok $stok)
    {
        // dd('tese');

        $validator = Validator::make($request->all(), [
            'id_kendaraan' => 'required|exists:kendaraan,_id',
            'jumlah' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        // return response($stok);

        $stok->update([
            'jumlah' => $request->jumlah,
        ]);

        return response()->json($stok, 200);
    }
}
