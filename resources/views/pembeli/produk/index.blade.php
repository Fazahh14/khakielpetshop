@extends('layouts.pembeli')

@section('title', 'Produk')

@section('content')
<style>
    .produk-card-hover {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        min-height: 280px;
        width: 100%;
    }

    .produk-card-hover:hover {
        transform: scale(1.05);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>

<div class="w-full max-w-7xl mx-auto px-4 py-6">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
        @foreach($produk as $item)
            <div class="produk-card-hover relative bg-white p-4 rounded-xl shadow-md transition-all duration-300 group">
                {{-- Link transparan untuk seluruh card --}}
                <a href="{{ route('pembeli.produk.show', $item->id) }}" class="absolute inset-0 z-10"></a>

                {{-- Gambar Produk --}}
                <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->nama }}"
                     class="h-48 w-full object-cover rounded mb-3 relative z-0">

                {{-- Konten --}}
                <div class="relative z-0 text-left">
                    {{-- Harga --}}
                    <p class="text-blue-600 font-bold text-sm mb-1 pl-2">
                        Rp {{ number_format($item->harga, 0, ',', '.') }}
                    </p>

                    {{-- Nama Produk --}}
                    <h3 class="text-base font-semibold line-clamp-2 mb-2 pl-2">{{ $item->nama }}</h3>

                    {{-- Tombol Lihat Selengkapnya --}}
                    <a href="{{ route('pembeli.produk.show', $item->id) }}"
                       class="inline-block bg-blue-500 text-white text-xs font-medium px-4 py-2 rounded-full hover:bg-blue-600 transition z-20 relative ml-2">
                        Lihat selengkapnya
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
