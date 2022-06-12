<?php

namespace App\Http\Controllers;

use App\Models\Motor;
use App\Models\Kendaraan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\MotorResource;
use Illuminate\Support\Facades\Validator;

class MotorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Motor::with([
            'kendaraan',
        ])->get();

        return MotorResource::collection($data);
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
            'tipe_suspensi'=> 'required|string',
            'tipe_transmisi'=> 'required|string',
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

            $motor = Motor::create([
                'id_kendaraan' => $kendaraan->id,
                'mesin' => $request->mesin,
                'tipe_suspensi' => $request->tipe_suspensi,
                'tipe_transmisi' => $request->tipe_transmisi,
            ]);

            $session->commitTransaction();
        } catch (\Throwable $th) {
            $session->abortTransaction();

            return response()->json($th->getMessage(), 400);
        }

        return MotorResource::make($motor);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Motor $motor)
    {
        return MotorResource::make($motor);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Motor $motor)
    {
        $validator = Validator::make($request->all(), [
            'mesin' => 'nullable|string',
            'tipe_suspensi' => 'nullable|string',
            'tipe_transmisi' => 'nullable|string',
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
            $motor->kendaraan->update($request->only(['tahun', 'warna', 'harga']));

            $motor = $motor->update($request->only(['mesin', 'tipe_suspensi', 'tipe_transmisi']));

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
    public function destroy(Motor $motor)
    {
        $motor->kendaraan()->delete();
        $motor->delete();

        return response()->json('success', 200);
    }
}
