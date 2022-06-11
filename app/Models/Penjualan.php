<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Penjualan extends Eloquent
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'penjualan';

    protected $fillable = [
        'id_kendaraan',
        'jumlah',
    ];

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class,'id_kendaraan','_id');
    }
    
}
