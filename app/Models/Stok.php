<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Stok extends Eloquent
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'stok';

    protected $fillable = [
        'id_kendaraan',
        'jumlah',
    ];
}
