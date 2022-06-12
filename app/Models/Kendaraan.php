<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Kendaraan extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'kendaraan';

    protected $fillable = [
        'tahun',
        'warna',
        'harga',
    ];

    
    public function motor()
    {
        return $this->hasOne(Motor::class, 'id_kendaraan');
    }
    public function mobil()
    {
        return $this->hasOne(Mobil::class, 'id_kendaraan');

    }
    public function penjualan()
    {
        return $this->hasMany(Motor::class, 'id_kendaraan','id');
    }
}
