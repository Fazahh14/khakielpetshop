<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id(); // primary key
            $table->string('order_id'); // ID transaksi unik dari Midtrans
            $table->string('nama'); // nama pembeli
            $table->text('alamat'); // alamat lengkap pembeli
            $table->string('telepon'); // nomor telepon pembeli
            $table->date('tanggal_pesanan'); // tanggal saat pesanan dibuat
            $table->integer('total'); // total harga
            $table->string('status')->default('pending'); // status pembayaran
            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
