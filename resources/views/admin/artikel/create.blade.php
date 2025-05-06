@extends('layouts.admin')

@section('title', 'Tambah Artikel')

@section('content')
<div class="p-6 max-w-3xl mx-auto animate-fade-in-up">
    <h1 class="text-3xl font-bold mb-6 text-left text-gray-800">Tambah Artikel Baru</h1>

    {{-- Notifikasi error --}}
    @if ($errors->any())
        <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-md shadow-sm mb-5">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li class="mb-1">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.artikel.store') }}" method="POST" enctype="multipart/form-data"
        class="bg-[#E5CBB7] p-6 rounded-2xl shadow-lg space-y-6 border border-[#d1b59a] transition-all duration-300">
        @csrf

        {{-- Judul --}}
        <div>
            <label class="block mb-2 font-semibold text-gray-800">Judul Artikel</label>
            <input type="text" name="judul" value="{{ old('judul') }}" required
                class="w-full bg-[#f0dfd0] text-gray-800 border border-gray-300 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm transition">
        </div>

        {{-- Konten --}}
        <div>
            <label class="block mb-2 font-semibold text-gray-800">Konten</label>
            <textarea name="konten" rows="6" required
                class="w-full bg-[#f0dfd0] text-gray-800 border border-gray-300 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm transition">{{ old('konten') }}</textarea>
        </div>

        {{-- Gambar --}}
        <div>
            <label class="block mb-2 font-semibold text-gray-800">Upload Gambar</label>
            <input type="file" name="gambar" accept="image/*"
                class="w-full bg-[#f0dfd0] text-gray-700 border border-gray-300 p-2 rounded-md focus:outline-none transition hover:bg-[#ecd3b5]" onchange="previewGambar(event)">
            <img id="preview" class="mt-4 w-60 h-auto hidden rounded-lg border border-gray-400 shadow-md" />
        </div>

        {{-- Tombol --}}
        <div class="flex justify-end gap-2 mt-4">
            <a href="{{ route('admin.artikel.index') }}"
                class="px-4 py-2 bg-gray-400 text-white rounded-md hover:bg-gray-500 transition font-medium shadow-sm">Batal</a>
            <button type="submit"
                class="px-5 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition font-semibold shadow-md hover:shadow-lg active:scale-95">Simpan Artikel</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<style>
    /* Animasi muncul dari bawah */
    .animate-fade-in-up {
        animation: fadeInUp 0.6s ease-out both;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<script>
    function previewGambar(event) {
        const input = event.target;
        const reader = new FileReader();
        const preview = document.getElementById('preview');

        reader.onload = function () {
            preview.src = reader.result;
            preview.classList.remove('hidden');
        }

        if (input.files && input.files[0]) {
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
