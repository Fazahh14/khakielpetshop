@extends('layouts.admin')

@section('title', 'Kelola Status Pesanan')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/statuspesanan/index.css') }}">
@endpush

@section('content')
<div class="container page-content">
    <div class="card">
        <h2 class="text-center mb-4 fw-bold text-uppercase text-dark">Kelola Status Pesanan</h2>

        <div class="top-controls">
            <a href="#" class="btn-tambah">+ Tambah Status</a>

            <form action="#" method="GET" class="search-box">
                <input type="text" name="search" class="search-input" placeholder="Cari nama pemesan...">
                <i class="bi bi-search"></i>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-hover text-center">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Pemesan</th>
                        <th>Nama Produk</th>
                        <th>Tanggal Pesanan</th>
                        <th>Status</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($statusPesanan as $status)
                    <tr>
                        <td>{{ $status->id }}</td>
                        <td>{{ $status->nama_pemesan }}</td>
                        <td>{{ $status->nama_produk }}</td>
                        <td>{{ $status->tanggal_pesanan ? \Carbon\Carbon::parse($status->tanggal_pesanan)->format('d F Y') : '-' }}</td>
                        <td>
                            <span class="badge 
                                @if($status->status_pesanan == 'sedang diproses') badge-proses
                                @elseif($status->status_pesanan == 'selesai') badge-selesai
                                @elseif($status->status_pesanan == 'belum diproses') badge-belum
                                @elseif($status->status_pesanan == 'pesanan dibatalkan') badge-batal
                                @endif">
                                {{ ucfirst($status->status_pesanan) }}
                            </span>
                        </td>
                        <td>Rp {{ number_format($status->harga, 0, ',', '.') }}</td>
                        <td>
                            <a href="{{ route('kelolastatuspesanan.edit', $status->id) }}" class="btn btn-sm btn-edit">Edit</a>
                            <form action="{{ route('kelolastatuspesanan.destroy', $status->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-hapus" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">Belum ada status pesanan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
