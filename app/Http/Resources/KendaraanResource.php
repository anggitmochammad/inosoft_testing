<?php

namespace App\Http\Resources;

use App\Models\Mobil;
use App\Models\Motor;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Resources\Json\JsonResource;

class KendaraanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        //  Alasan memakai ini karena hasone di model tidak jalan 
        $mobil = Mobil::where('id_kendaraan',$this->_id)->first();
        $motor = Motor::where('id_kendaraan',$this->_id)->first();

        return [
            'id' => $this->id,
            'tahun' => $this->tahun,
            'warna' => $this->warna,
            'harga' => $this->harga,
            'jenis' => $mobil ? 'mobil' : 'motor',
            'mobil' => MobilResource::make($mobil),
            'motor' => MotorResource::make($motor),
        ];
    }
}
