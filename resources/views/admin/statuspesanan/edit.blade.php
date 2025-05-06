@extends('layouts.admin')

@section('title', 'Edit Status Pesanan')

@push('styles')
<style>
    .form-container {
        background: #E5CBB7;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        animation: fadeIn 0.6s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .form-label {
        font-weight: 600;
    }

    .btn-primary {
        background-color: #0d6efd;
        border: none;
    }

    .btn-primary:hover {
        background-color: #0b5ed7;
    }
</style>
@endpush

@section('content')
<div class="container py-4">
    <div class="form-container mx-auto" style="max-width: 600px;">
        <h3 class="text-center fw-bold text-dark mb-4">Edit Status Pesanan</h3>

        {{-- Error Message --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form --}}
        <form action="{{ route('kelolastatuspesanan.update', $status->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="status_pesanan" class="form-label">Status Pesanan</label>
                <select name="status_pesanan" id="status_pesanan" class="form-select" required>
                    <option value="">-- Pilih Status --</option>
                    <option value="belum diproses" {{ $status->status_pesanan == 'belum diproses' ? 'selected' : '' }}>Belum Diproses</option>
                    <option value="sedang diproses" {{ $status->status_pesanan == 'sedang diproses' ? 'selected' : '' }}>Sedang Diproses</option>
                    <option value="selesai" {{ $status->status_pesanan == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="pesanan dibatalkan" {{ $status->status_pesanan == 'pesanan dibatalkan' ? 'selected' : '' }}>Pesanan Dibatalkan</option>
                </select>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('kelolastatuspesanan.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
