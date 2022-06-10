<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;


class Motor extends Eloquent
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'motor';

    protected $fillable = [
        'id_kendaraan',
        'mesin',
        'tipe_suspensi',
        'tipe_transmisi',
    ];
}
