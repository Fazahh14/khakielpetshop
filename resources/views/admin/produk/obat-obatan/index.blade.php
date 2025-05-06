@extends('layouts.admin')

@section('title', 'Kelola Produk Obat-obatan')

@section('content')
<div class="container py-4">

    {{-- Header --}}
    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between bg-light px-4 py-3 rounded shadow mb-4 gap-3">
        <a href="{{ route('obat-obatan.create') }}" class="btn btn-secondary">
            + Tambah Produk
        </a>

        <h2 class="h5 text-center flex-grow-1 mb-0 fw-bold text-dark">Kelola Produk Obat-obatan</h2>

        <div class="d-flex align-items-center gap-2">
            <div class="input-group">
                <input type="text" id="searchInput" oninput="searchTable()" class="form-control" placeholder="Cari nama produk...">
                <span class="input-group-text"><i class="bi bi-search"></i></span>
            </div>
        </div>
    </div>

    {{-- Tabel --}}
    <div class="table-responsive shadow rounded bg-white">
        <table class="table table-bordered table-hover align-middle text-center" id="produkTable">
            <thead class="table-secondary text-uppercase text-dark">
                <tr>
                    <th>ID</th>
                    <th>Nama Produk</th>
                    <th>Stok</th>
                    <th>Harga</th>
                    <th>Deskripsi</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($produk as $p)
                    <tr>
                        <td>{{ $p->id }}</td>
                        <td>{{ $p->nama }}</td>
                        <td>{{ $p->stok }}</td>
                        <td>Rp {{ number_format($p->harga, 0, ',', '.') }}</td>
                        <td>{{ $p->deskripsi }}</td>
                        <td>
                            @if($p->gambar)
                                <img src="{{ asset('storage/' . $p->gambar) }}" class="img-thumbnail" style="width: 64px; height: 64px; object-fit: cover;" alt="gambar">
                            @else
                                <span class="text-muted fst-italic">Tidak ada</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('obat-obatan.edit', $p->id) }}" class="btn btn-warning btn-sm">
                                    Edit
                                </a>
                                <form action="{{ route('obat-obatan.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Yakin ingin hapus produk ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-muted py-3">Tidak ada produk ditemukan.</td>
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
