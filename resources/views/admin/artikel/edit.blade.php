@extends('layouts.admin')

@section('title', 'Edit Artikel')

@section('content')
<div class="p-6 max-w-3xl mx-auto animate-fade-in-up">
    <h1 class="text-3xl font-bold mb-6 text-center text-gray-800">✏️ Edit Artikel</h1>

    {{-- Tampilkan error validasi --}}
    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded mb-5 border border-red-300 shadow-sm">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li class="mb-1">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.artikel.update', $artikel->id) }}" method="POST" enctype="multipart/form-data"
        class="space-y-6 bg-[#E5CBB7] p-6 rounded-2xl shadow-lg transition-all duration-300 border border-[#d1b59a]">
        @csrf
        @method('PUT')

        {{-- Judul --}}
        <div>
            <label class="block mb-2 font-semibold text-gray-800">Judul Artikel</label>
            <input type="text" name="judul" value="{{ old('judul', $artikel->judul) }}" required
                class="w-full bg-[#f0dfd0] text-gray-800 border border-gray-300 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm transition">
        </div>

        {{-- Konten --}}
        <div>
            <label class="block mb-2 font-semibold text-gray-800">Konten</label>
            <textarea name="konten" rows="6" required
                class="w-full bg-[#f0dfd0] text-gray-800 border border-gray-300 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm transition">{{ old('konten', $artikel->konten) }}</textarea>
        </div>

        {{-- Gambar --}}
        <div>
            <label class="block mb-2 font-semibold text-gray-800">Upload Gambar Baru (Opsional)</label>
            <input type="file" name="gambar" accept="image/*"
                class="w-full bg-[#f9f5f2] text-gray-700 border border-gray-300 p-2 rounded-md focus:outline-none transition hover:bg-[#ecd3b5]" onchange="previewGambar(event)">

            @if ($artikel->gambar)
                <p class="mt-4 text-sm text-gray-700 font-medium">Gambar Lama:</p>
                <img src="{{ asset('storage/' . $artikel->gambar) }}" alt="Gambar Lama"
                    class="w-60 h-auto mt-2 rounded-md border border-gray-400 shadow">
            @endif

            <img id="preview" class="mt-4 w-60 h-auto hidden rounded-md border border-gray-400 shadow-md" />
        </div>

        {{-- Tombol --}}
        <div class="flex justify-end gap-2">
            <a href="{{ route('admin.artikel.index') }}"
                class="px-4 py-2 bg-gray-400 text-white rounded-md hover:bg-gray-500 transition font-medium shadow-sm">
                Batal
            </a>
            <button type="submit"
                class="px-5 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 transition font-semibold shadow-md hover:shadow-lg active:scale-95">
                Update Artikel
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<style>
    .animate-fade-in-up {
        animation: fadeInUp 0.5s ease-out both;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
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
