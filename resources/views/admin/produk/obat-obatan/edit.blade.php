@extends('layouts.admin')

@section('title', 'Edit Produk Obat-obatan')

@section('content')
@if(session('success'))
    <div class="max-w-xl mx-auto mb-6">
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded text-sm">
            {{ session('success') }}
        </div>
    </div>
@endif

<div class="max-w-4xl mx-auto bg-[#E5CBB7] rounded-3xl shadow-lg p-8 flex flex-col md:flex-row items-center gap-8">
    <div class="w-full md:w-1/2">
        <h2 class="text-3xl font-bold text-center mb-6">Edit Produk</h2>

        <form action="{{ route('obat-obatan.update', $produk->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label for="nama" class="block font-medium mb-1">Nama Produk</label>
                <input type="text" name="nama" id="nama" value="{{ old('nama', $produk->nama) }}" required
                    class="w-full px-4 py-2 border rounded-md bg-[#FFFCF0] focus:ring-orange-300 focus:outline-none">
                @error('nama') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="stok" class="block font-medium mb-1">Stok</label>
                <input type="number" name="stok" id="stok" value="{{ old('stok', $produk->stok) }}" required
                    class="w-full px-4 py-2 border rounded-md bg-[#FFFCF0] focus:ring-orange-300 focus:outline-none">
                @error('stok') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="harga" class="block font-medium mb-1">Harga</label>
                <input type="number" name="harga" id="harga" value="{{ old('harga', $produk->harga) }}" required
                    class="w-full px-4 py-2 border rounded-md bg-[#FFFCF0] focus:ring-orange-300 focus:outline-none">
                @error('harga') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="deskripsi" class="block font-medium mb-1">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" rows="4"
                    class="w-full px-4 py-2 border rounded-md bg-[#FFFCF0] focus:ring-orange-300 focus:outline-none">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
                @error('deskripsi') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="gambar" class="block font-medium mb-1">Gambar Produk</label>
                @if($produk->gambar)
                    <p class="mb-2 text-sm text-gray-800">File tersimpan: <strong>{{ basename($produk->gambar) }}</strong></p>
                @endif
                <input type="file" name="gambar" id="gambar"
                    class="w-fit bg-[#FFFCF0] border border-gray-300 rounded px-4 py-2">
                <p class="text-sm text-gray-600 mt-1">Format: JPG, PNG, GIF (maks. 2MB)</p>
                @error('gambar') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="text-center mt-6">
                <button type="submit"
                    class="bg-[#D9D9D9] text-black px-6 py-2 rounded-md font-semibold hover:bg-[#c6c6c6] transition">
                    Simpan
                </button>
            </div>
        </form>
    </div>

    <div class="w-full md:w-1/2 text-center">
        <img src="{{ asset('images/ilustrasi-kucing.png') }}" class="w-3/4 mx-auto" alt="Ilustrasi">
    </div>
</div>
@endsection
