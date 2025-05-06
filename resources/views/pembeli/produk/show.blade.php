@extends('layouts.pembeli')

@section('title', 'Detail Produk')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">

    <div class="flex flex-col md:flex-row md:items-start gap-10">

        {{-- Gambar --}}
        <div class="bg-white p-4 rounded-xl shadow-md inline-block">
            <img src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama }}"
                 class="w-[410px] h-[460px] rounded-lg object-cover">
        </div>

        {{-- Informasi Produk --}}
        <div class="flex-1 mt-15">
            <div class="space-y-2 max-w-[410px]">
                <h2 class="text-[30px] font-semibold text-gray-800 leading-snug">{{ $produk->nama }}</h2>
                <p class="text-sm text-gray-700">
                    <span class="font-medium">Merek:</span>
                    <span class="text-blue-500 lowercase">{{ $produk->merek ?? '-' }}</span> |
                    <span class="font-medium">Kategori:</span>
                    {{ ucfirst($produk->kategori) }}
                </p>
                <p class="text-[27px] text-sky-600 font-semibold">Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
            </div>

            {{-- Tombol Aksi --}}
            <div class="bg-neutral-50 border border-gray-300 p-4 rounded-xl mt-6 shadow-sm space-y-3 w-[460px]">

                <div class="flex justify-between px-1 pt-1">
                    {{-- ✅ Tombol Pesan Sekarang (terhubung ke checkout.storeProduk) --}}
                    <form action="{{ route('checkout.storeProduk') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $produk->id }}">
                        <input type="hidden" name="nama" value="{{ $produk->nama }}">
                        <input type="hidden" name="harga" value="{{ $produk->harga }}">
                        <input type="hidden" name="jumlah" value="1">
                        <input type="hidden" name="gambar" value="{{ $produk->gambar ?? 'default.png' }}">

                        <button type="submit" class="bg-[#E5CBB7] text-sm px-4 py-2 rounded-full font-medium hover:opacity-90 transition">
                            🛍️ Pesan Sekarang
                        </button>
                    </form>

                    {{-- Tombol Tambah ke Keranjang --}}
                    <form action="{{ route('keranjang.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $produk->id }}">
                        <input type="hidden" name="nama" value="{{ $produk->nama }}">
                        <input type="hidden" name="harga" value="{{ $produk->harga }}">
                        <input type="hidden" name="jumlah" value="1">
                        <input type="hidden" name="gambar" value="{{ $produk->gambar ?? 'default.png' }}">

                        <button type="submit" class="bg-[#E5CBB7] text-sm px-4 py-2 rounded-full font-medium hover:opacity-90 transition">
                            ➕ Tambah ke Keranjang
                        </button>
                    </form>
                </div>

                {{-- Wishlist --}}
                <div class="flex items-center justify-between border px-4 py-2 rounded-md mt-2">
                    @auth
                        <button id="wishlistBtn" class="flex items-center gap-2 text-sm text-gray-700 transition">
                            <svg id="wishlistIcon" xmlns="http://www.w3.org/2000/svg" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5 transition-all">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M4.318 6.318a4.5 4.5 0 0 1 6.364 0L12 7.636l1.318-1.318a4.5 
                                      4.5 0 1 1 6.364 6.364L12 20.364l-7.682-7.682a4.5 
                                      4.5 0 0 1 0-6.364z" />
                            </svg>
                            <span>Tambahkan ke Kesukaan</span>
                        </button>
                    @else
                        <a href="{{ route('login') }}" class="flex items-center gap-2 text-sm text-gray-700 hover:text-red-500 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M4.318 6.318a4.5 4.5 0 0 1 6.364 0L12 7.636l1.318-1.318a4.5 
                                      4.5 0 1 1 6.364 6.364L12 20.364l-7.682-7.682a4.5 
                                      4.5 0 0 1 0-6.364z" />
                            </svg>
                            <span>Tambahkan ke Kesukaan</span>
                        </a>
                    @endauth

                    <span class="text-sm font-medium">Stok: {{ $produk->stok }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Deskripsi --}}
    <div class="bg-white mt-14 p-6 rounded-xl shadow-md">
        <h3 class="text-lg font-semibold mb-3">Deskripsi Produk</h3>
        <p class="text-sm leading-relaxed text-gray-700 whitespace-pre-wrap">
            {!! nl2br(e($produk->deskripsi ?? 'Tidak ada deskripsi tersedia.')) !!}
        </p>
    </div>
</div>
@endsection

@push('scripts')
@auth
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const wishlistBtn = document.getElementById('wishlistBtn');
        const wishlistIcon = document.getElementById('wishlistIcon');
        let liked = false;

        wishlistBtn.addEventListener('click', function () {
            liked = !liked;
            if (liked) {
                wishlistIcon.setAttribute('fill', 'currentColor');
                wishlistIcon.setAttribute('stroke', 'none');
                wishlistIcon.classList.add('text-red-500');
            } else {
                wishlistIcon.setAttribute('fill', 'none');
                wishlistIcon.setAttribute('stroke', 'currentColor');
                wishlistIcon.classList.remove('text-red-500');
            }
        });
    });
</script>
@endauth
@endpush
