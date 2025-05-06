@extends('layouts.admin')

@section('title', 'Kelola Artikel')

@section('content')
<div class="max-w-7xl mx-auto">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between bg-[#E5CBB7] px-6 py-4 rounded-md mb-6 gap-3 shadow-md">
        <a href="{{ route('admin.artikel.create') }}"
           class="bg-[#D9D9D9] hover:bg-gray-300 text-black px-4 py-2 rounded text-sm font-medium transition shadow-sm">
            + Tambah Artikel
        </a>

        <h2 class="text-xl font-bold text-center flex-1 text-gray-800">Kelola Artikel</h2>

        <div class="flex items-center gap-2 justify-end">
            <div class="flex items-center bg-white px-3 py-1 rounded shadow-inner border border-gray-300">
                <input type="text" id="searchInput" placeholder="Cari judul artikel..."
                       class="bg-transparent outline-none text-sm w-32 md:w-54"
                       oninput="searchTable()" />
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 103 10.5a7.5 7.5 0 0013.15 6.15z" />
                </svg>
            </div>
        </div>
    </div>

    {{-- Pesan sukses --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4 border border-green-300">
            {{ session('success') }}
        </div>
    @endif

    {{-- Tabel Artikel --}}
    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="min-w-full text-sm text-left" id="artikelTable">
            <thead class="bg-gray-100 text-gray-700 uppercase">
                <tr>
                    <th class="px-6 py-3">Judul</th>
                    <th class="px-6 py-3">Tanggal</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($artikel as $a)
                <tr class="border-b hover:bg-[#FAF3EB] transition">
                    <td class="px-6 py-4">{{ $a->judul }}</td>
                    <td class="px-6 py-4">{{ $a->created_at->format('d M Y') }}</td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex justify-center gap-2">
                            <a href="{{ route('admin.artikel.edit', $a->id) }}"
                               class="flex items-center gap-1 bg-yellow-400 text-black px-3 py-1 rounded hover:bg-yellow-500 transition text-sm font-medium shadow-sm">
                                ✏️ Edit
                            </a>
                            <form action="{{ route('admin.artikel.destroy', $a->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus artikel ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="flex items-center gap-1 bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition text-sm font-medium shadow-sm">
                                    🗑️ Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-6 py-4 text-center text-gray-500">Belum ada artikel.</td>
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
        const rows = document.querySelectorAll("#artikelTable tbody tr");

        rows.forEach(row => {
            const judul = row.cells[0].textContent.toLowerCase();
            row.style.display = judul.includes(input) ? "" : "none";
        });
    }
</script>
@endpush
@endsection
