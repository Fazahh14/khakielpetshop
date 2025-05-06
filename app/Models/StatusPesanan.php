<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusPesanan extends Model
{
    protected $fillable = [
        'nama_pemesan',
        'nama_produk',
        'tanggal_pesanan',
        'status_pesanan',
        'harga',
    ];
}
