<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Mobil extends Eloquent
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'mobil';

    protected $fillable = [
        'id_kendaraan',
        'mesin',
        'kapasitas_penumpang',
        'tipe',
    ];

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class,'id_kendaraan','_id');
    }
}
