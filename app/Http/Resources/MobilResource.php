<?php

namespace App\Http\Resources;

use App\Models\Kendaraan;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Resources\Json\JsonResource;

class MobilResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if (Route::is('mobil.show') || Route::is('mobil.store')) {
            return[
                '_id' => $this->id,
                'id_kendaraan' => $this->id_kendaraan,
                'mesin' => $this->mesin,
                'kapasitas_penumpang' => $this->kapasitas_penumpang,
                'tipe' => $this->tipe,
                'harga' => $this->kendaraan->harga,
                'tahun' => $this->kendaraan->tahun,
                'warna' => $this->kendaraan->warna,
            ];
        }else{
            return parent::toArray($request);
        }
       
    }
}
