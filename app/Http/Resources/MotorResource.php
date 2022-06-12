<?php

namespace App\Http\Resources;

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Resources\Json\JsonResource;

class MotorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if (Route::is('motor.show') || Route::is('motor.store')) {
            return [
                '_id' => $this->id,
                'id_kendaraan' => $this->id_kendaraan,
                'mesin' => $this->mesin,
                'tipe_transmisi' => $this->tipe_transmisi,
                'tipe_suspensi' => $this->tipe_suspensi,
                'harga' => $this->kendaraan->harga,
                'tahun' => $this->kendaraan->tahun,
                'warna' => $this->kendaraan->warna,
            ];
        } else {
            return parent::toArray($request);
        }
    }
}
