@extends('layouts.admin')

@section('title', 'Kelola Produk Vitamin Kucing')

@section('content')
<div class="max-w-7xl mx-auto">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between bg-[#E5CBB7] px-6 py-4 rounded-md mb-6 gap-3 shadow-md">
        <a href="{{ route('vitamin-kucing.create') }}"
           class="bg-[#D9D9D9] hover:bg-gray-300 text-black px-4 py-2 rounded text-sm font-medium transition">
            + Tambah Produk
        </a>

        <h2 class="text-xl font-bold text-center flex-1 text-gray-800">Kelola Produk Vitamin Kucing</h2>

        <div class="flex items-center gap-2 justify-end">
            <div class="flex items-center bg-white px-3 py-1 rounded shadow-inner border border-gray-300">
                <input type="text" id="searchInput" placeholder="Cari nama produk..."
                       class="bg-transparent outline-none text-sm w-32 md:w-54"
                       oninput="searchTable()" />
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 103 10.5a7.5 7.5 0 0013.15 6.15z" />
                </svg>
            </div>
        </div>
    </div>

    {{-- Tabel --}}
    <div class="w-full overflow-x-auto bg-white rounded-lg shadow-md max-w-screen-xl mx-auto">
        <table class="w-full table-auto text-sm text-center border-collapse" id="produkTable">
            <thead class="bg-[#D9D9D9] text-gray-700 uppercase tracking-wide">
                <tr>
                    <th class="py-[10px] px-[14px] border">No</th>
                    <th class="py-[10px] px-[14px] border">Nama Produk</th>
                    <th class="py-[10px] px-[14px] border">Stok</th>
                    <th class="py-[10px] px-[14px] border">Harga</th>
                    <th class="py-[10px] px-[14px] border">Deskripsi</th>
                    <th class="py-[10px] px-[14px] border">Gambar</th>
                    <th class="py-[10px] px-[14px] border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($produk as $index => $p)
                    <tr class="hover:bg-[#FAF3EB] transition">
                        <td class="py-[8px] px-[12px] border">{{ $index + 1 }}</td>
                        <td class="py-[8px] px-[12px] border">{{ $p->nama }}</td>
                        <td class="py-[8px] px-[12px] border">{{ $p->stok }}</td>
                        <td class="py-[8px] px-[12px] border">Rp {{ number_format($p->harga, 0, ',', '.') }}</td>
                        <td class="py-[8px] px-[12px] border">{{ $p->deskripsi }}</td>
                        <td class="py-[8px] px-[12px] border">
                            @if($p->gambar)
                                <img src="{{ asset('storage/' . $p->gambar) }}" class="w-16 h-16 object-cover rounded mx-auto block" alt="gambar">
                            @else
                                <span class="text-sm text-gray-500 italic">Tidak ada</span>
                            @endif
                        </td>
                        <td class="py-[8px] px-[12px] border">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('vitamin-kucing.edit', $p->id) }}"
                                   class="bg-yellow-300 hover:bg-yellow-400 text-black px-3 py-1 rounded text-base font-semibold transition flex items-center">
                                    Edit
                                </a>
                                <form action="{{ route('vitamin-kucing.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Yakin ingin hapus produk ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="border border-red-500 text-red-500 hover:bg-red-500 hover:text-white px-3 py-1 rounded text-base font-semibold transition flex items-center">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-4 text-gray-500">Tidak ada produk ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script>
    function searchTable() {
        const input = document.getElementById("searchInput").value.toLowerCase();
        const rows = document.querySelectorAll("#produkTable tbody tr");

        rows.forEach(row => {
            const nama = row.cells[1].textContent.toLowerCase();
            row.style.display = nama.includes(input) ? "" : "none";
        });
    }
</script>
@endpush
@endsection
