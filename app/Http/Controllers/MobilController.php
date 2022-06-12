<?php

namespace App\Http\Controllers;

use App\Models\Mobil;
use Illuminate\Http\Request;
use App\Http\Resources\MobilResource;
use App\Models\Kendaraan;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class MobilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Mobil::with([
            'kendaraan',
        ])->get();

        return MobilResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mesin' => 'required|string',
            'kapasitas_penumpang' => 'required|string',
            'tipe' => 'required|string',
            'tahun' => 'required|string|min:4|max:5',
            'warna' => 'required|string',
            'harga' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->all());
        }

        $session = DB::getMongoClient()->startSession();
        $session->startTransaction();

        try {
            $kendaraan = Kendaraan::create($request->only(['tahun', 'warna', 'harga']));

            $mobil = Mobil::create([
                'id_kendaraan' => $kendaraan->id,
                'mesin' => $request->mesin,
                'kapasitas_penumpang' => $request->kapasitas_penumpang,
                'tipe' => $request->tipe,
            ]);

            $session->commitTransaction();

        } catch (\Throwable $th) {
            $session->abortTransaction();

            return response()->json($th->getMessage(), 400);
        }

        return MobilResource::make($mobil);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Mobil $mobil)
    {
        return MobilResource::make($mobil);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mobil $mobil)
    {
        $validator = Validator::make($request->all(), [
            'mesin' => 'nullable|string',
            'kapasitas_penumpang' => 'nullable|string',
            'tipe' => 'nullable|string',
            'tahun' => 'nullable|string|min:4|max:5',
            'warna' => 'nullable|string',
            'harga' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->all());
        }

        $session = DB::getMongoClient()->startSession();
        $session->startTransaction();

        try {
            $mobil->kendaraan->update($request->only(['tahun', 'warna', 'harga']));

            $mobil = $mobil->update($request->only(['mesin', 'kapasitas_penumpang', 'tipe']));

            $session->commitTransaction();
        } catch (\Throwable $th) {
            $session->abortTransaction();

            return response()->json($th->getMessage(), 400);
        }

        return response()->json('success', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mobil $mobil)
    {
        $mobil->kendaraan()->delete();
        $mobil->delete();

        return response()->json('success', 200);
    }
}
