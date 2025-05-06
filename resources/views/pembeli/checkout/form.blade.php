@extends('layouts.pembeli')

@section('title', 'Checkout')

@section('content')
<style>
    .form-label {
        min-width: 130px;
        display: inline-block;
        font-weight: 500;
        color: #333;
    }

    .input-group {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .btn-pesan {
        background-color: #ffffff;
        border: 1px solid #ccc;
        color: #333;
        padding: 10px 24px;
        font-weight: 600;
        border-radius: 6px;
        transition: 0.3s;
    }

    .btn-pesan:hover {
        background-color: #f3f3f3;
    }

    .form-wrapper {
        background-color: #E5CBB7;
        padding: 24px;
        border-radius: 10px;
        box-shadow: 0 1px 6px rgba(0, 0, 0, 0.1);
        max-width: 600px;
        margin: 0 auto;
    }
</style>

<div class="py-12 px-4">
    <div class="form-wrapper">
        <h2 class="text-center text-md font-semibold mb-6">Silakan isi form pemesanan terlebih dahulu</h2>

        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('checkout.process') }}" class="space-y-4">
            @csrf

            {{-- Nama --}}
            <div class="input-group">
                <label for="nama" class="form-label">Nama Pemesan</label>
                <input type="text" name="nama" id="nama" required
                    class="w-full border px-3 py-1.5 rounded bg-white text-sm focus:outline-none">
            </div>

            {{-- Alamat --}}
            <div class="input-group">
                <label for="alamat" class="form-label">Alamat Pemesan</label>
                <input type="text" name="alamat" id="alamat" required
                    class="w-full border px-3 py-1.5 rounded bg-white text-sm focus:outline-none">
            </div>

            {{-- Telepon --}}
            <div class="input-group">
                <label for="telepon" class="form-label">No Telepon</label>
                <input type="text" name="telepon" id="telepon" required
                    class="w-full border px-3 py-1.5 rounded bg-white text-sm focus:outline-none">
            </div>

            {{-- Metode Pembayaran --}}
            <div class="input-group">
                <label for="metode" class="form-label">Metode Pembayaran</label>
                <select name="metode" id="metode" required class="w-full border px-3 py-1.5 rounded bg-white text-sm">
                    <option value="">-- Pilih Metode --</option>
                    <option value="midtrans">Midtrans (VA/Qris)</option>
                    <option value="cod">COD</option>
                    <option value="dana">Dana</option>
                </select>
            </div>

            {{-- Tanggal --}}
            <div class="input-group">
                <label class="form-label">Tanggal Pesanan</label>
                <input type="text" name="tanggal_pesanan" value="{{ now()->format('Y-m-d') }}" readonly
                    class="w-full border px-3 py-1.5 rounded bg-gray-100 text-sm text-gray-700">
            </div>

            {{-- Total --}}
            @if($produk)
                <input type="hidden" name="total" value="{{ $produk['harga'] * $produk['jumlah'] }}">
            @else
                <input type="hidden" name="total" value="10000"> {{-- fallback default --}}
            @endif

            {{-- Tombol --}}
            <div class="text-center mt-6">
                <button type="submit" class="btn-pesan">
                    Pesan Sekarang
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
