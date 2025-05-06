<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = [
        'order_id',
        'nama',
        'alamat',
        'telepon',
        'tanggal_pesanan',
        'total',
        'status'
    ];
}
