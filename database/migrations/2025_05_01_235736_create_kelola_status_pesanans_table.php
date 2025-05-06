<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKelolaStatusPesanansTable extends Migration
{
    public function up()
    {
        Schema::create('status_pesanans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pemesan');
            $table->string('nama_produk');
            $table->date('tanggal_pesanan')->nullable();
            $table->string('status_pesanan');
            $table->unsignedBigInteger('harga');
            $table->timestamps();
        });
            
    }

    public function down()
    {
        Schema::dropIfExists('kelola_status_pesanans');
    }
}