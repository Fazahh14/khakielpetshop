<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Khakiel Petshop')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        .dropdown-button:hover span {
            color: #2563eb;
        }
    </style>

    @stack('styles')
</head>
<body class="bg-[#F7EFE5] font-sans min-h-screen flex flex-col">

    {{-- Header --}}
    <header class="bg-[#E5CBB7] px-6 py-4 shadow">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

            {{-- Logo --}}
            <div class="flex items-center space-x-4">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" class="w-14">
                <div>
                    <span class="font-bold text-lg block">KHAKIEL PETSHOP</span>
                    <small class="text-sm">Kebutuhan hewan kucing terlengkap</small>
                </div>
            </div>

            {{-- Form Pencarian --}}
            <form action="{{ route('pembeli.produk.index') }}" method="GET" class="flex w-full md:max-w-3xl ml-4">
                <div class="flex w-full border border-gray-300 rounded-md overflow-hidden bg-white">
                    <input type="text" name="search" placeholder="Cari produk..." value="{{ request('search') }}"
                        class="w-full px-4 py-3 text-[15px] focus:outline-none">
                    <button type="submit"
                        class="px-4 flex items-center justify-center bg-white hover:bg-gray-100 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-orange-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-4.35-4.35m1.43-5.57a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </button>
                </div>
            </form>

            {{-- Login / Keranjang / Avatar --}}
            <div class="flex items-center gap-5">
                {{-- Icon Keranjang --}}
                @php
                    $jumlahKeranjang = session('keranjang') ? count(session('keranjang')) : 0;
                @endphp

                <a href="{{ route('keranjang.index') }}" class="relative group">
                    {{-- SVG Ikon Keranjang --}}
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                         class="w-7 h-7 text-gray-800 hover:text-blue-600 transition">
                        <circle cx="9" cy="21" r="1"></circle>
                        <circle cx="20" cy="21" r="1"></circle>
                        <path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"></path>
                    </svg>

                    {{-- Badge jumlah produk --}}
                    @if($jumlahKeranjang > 0)
                        <span class="absolute -top-2 -right-2 bg-blue-500 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">
                            {{ $jumlahKeranjang }}
                        </span>
                    @endif
                </a>

                @auth
                    @php $initial = strtoupper(substr(Auth::user()->email, 0, 1)); @endphp
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open"
                            class="w-9 h-9 rounded-full bg-orange-500 text-white font-semibold text-sm flex items-center justify-center hover:ring-2 ring-orange-300 transition">
                            {{ $initial }}
                        </button>
                        <div x-show="open" @click.away="open = false" x-transition
                            class="absolute right-0 mt-2 w-36 bg-white border border-gray-300 rounded-md shadow-md z-50">
                            <div class="px-4 py-2 text-gray-700 text-sm border-b break-all">{{ Auth::user()->email }}</div>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-red-100 hover:text-red-600 transition">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}"
                        class="px-6 py-2 bg-white border border-gray-300 rounded-md text-base hover:bg-gray-100 transition font-medium text-gray-800">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}"
                        class="px-6 py-2 bg-orange-500 text-white rounded-md text-base hover:bg-orange-600 transition font-medium">
                        Daftar
                    </a>
                @endauth
            </div>
        </div>

        {{-- Navbar Dropdown --}}
        <nav class="flex justify-center gap-6 text-base font-medium mt-6 items-center relative">
            <a href="#" class="transition duration-300 hover:text-blue-500 text-black">Blog</a>
            <a href="#" class="transition duration-300 hover:text-blue-500 text-black">Status Pesanan</a>
            <a href="#" class="transition duration-300 hover:text-blue-500 text-black">Notifikasi Pembayaran</a>

            {{-- Dropdown Kebutuhan Kucing --}}
            @php
                $kategori = match(request('kategori')) {
                    'makanan-kucing' => 'Makanan Kucing',
                    'aksesoris' => 'Aksesoris',
                    'perlengkapan' => 'Perlengkapan',
                    'obat-obatan' => 'Obat-obatan',
                    'vitamin-kucing' => 'Vitamin',
                    default => 'Kebutuhan Kucing',
                };
            @endphp

            <div x-data="{ open: false }" class="dropdown relative" @mouseleave="open = false">
                <button @mouseenter="open = true"
                    class="dropdown-button flex items-center gap-2 px-4 py-2 font-medium text-gray-800 bg-transparent transition">
                    <span>🐾 {{ $kategori }}</span>
                    <svg class="h-4 w-4 text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="open" x-transition.duration.200ms
                    class="dropdown-menu absolute right-0 mt-2 w-52 rounded-md shadow-md z-50 bg-[#E5CBB7]"
                    @mouseenter="open = true" @mouseleave="open = false">

                    <a href="{{ route('pembeli.produk.index') }}"
                        class="block px-4 py-2 hover:text-blue-600 text-base transition {{ request('kategori') == null ? 'font-semibold text-orange-900' : '' }}">
                        🐾 Semua Produk
                    </a>
                    <a href="{{ route('pembeli.produk.index', ['kategori' => 'makanan-kucing']) }}"
                        class="block px-4 py-2 hover:text-blue-600 text-base transition {{ request('kategori') == 'makanan-kucing' ? 'font-semibold text-orange-900' : '' }}">
                        🐾 Makanan Kucing
                    </a>
                    <a href="{{ route('pembeli.produk.index', ['kategori' => 'aksesoris']) }}"
                        class="block px-4 py-2 hover:text-blue-600 text-base transition {{ request('kategori') == 'aksesoris' ? 'font-semibold text-orange-900' : '' }}">
                        🐾 Aksesoris
                    </a>
                    <a href="{{ route('pembeli.produk.index', ['kategori' => 'perlengkapan']) }}"
                        class="block px-4 py-2 hover:text-blue-600 text-base transition {{ request('kategori') == 'perlengkapan' ? 'font-semibold text-orange-900' : '' }}">
                        🐾 Perlengkapan
                    </a>
                    <a href="{{ route('pembeli.produk.index', ['kategori' => 'obat-obatan']) }}"
                        class="block px-4 py-2 hover:text-blue-600 text-base transition {{ request('kategori') == 'obat-obatan' ? 'font-semibold text-orange-900' : '' }}">
                        🐾 Obat-obatan
                    </a>
                    <a href="{{ route('pembeli.produk.index', ['kategori' => 'vitamin-kucing']) }}"
                        class="block px-4 py-2 hover:text-blue-600 text-base transition {{ request('kategori') == 'vitamin-kucing' ? 'font-semibold text-orange-900' : '' }}">
                        🐾 Vitamin
                    </a>
                </div>
            </div>
        </nav>
    </header>

    {{-- Konten --}}
    <main class="flex-1 container mx-auto py-10 px-4">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-[#E5CBB7] text-sm text-gray-800 px-6 py-6 mt-auto">
        <div class="flex flex-col md:flex-row justify-between gap-6">
            <div>
                <p class="font-bold text-lg">KHAKIEL PETSHOP</p>
                <p>Kebutuhan hewan kucing terlengkap</p>
                <p>Jl. Pamayahan No.20, Kukusan, Kecamatan Lohbener, Indramayu, Jawa Barat 65252</p>
            </div>
            <div>
                <p>WhatsApp:
                    <a href="https://api.whatsapp.com/send?phone=6287717649173"
                        class="text-blue-600 hover:underline">
                        087-717-649-173
                    </a>
                </p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
