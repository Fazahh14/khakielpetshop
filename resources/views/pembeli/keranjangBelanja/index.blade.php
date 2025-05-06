@extends('layouts.pembeli')

@section('title', 'Keranjang Belanja')

@push('styles')
<style>
    .fade-out {
        opacity: 0;
        transform: scale(0.95);
        transition: all 0.4s ease-in-out;
    }
</style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-semibold mb-6">Keranjang Belanja</h1>

    @if (count($keranjang) > 0)
        {{-- Pilih Semua --}}
        <div class="bg-white p-4 rounded-lg shadow mb-6">
            <div class="flex items-center">
                <input type="checkbox" id="pilih-semua" class="w-5 h-5 text-blue-600">
                <label for="pilih-semua" class="ml-3 text-lg font-semibold text-gray-800">
                    Pilih Semua (<span id="jumlah-dipilih">0</span> produk)
                </label>
            </div>
        </div>

        {{-- List Produk --}}
        <div class="bg-white p-4 rounded-lg shadow space-y-4">
            <div id="keranjang-list">
                @foreach ($keranjang as $id => $item)
                    <div class="flex items-center pt-3 pb-6 border-b last:border-none" data-id="{{ $id }}">
                        <input type="checkbox" name="checked_items[]" value="{{ $id }}" class="item-checkbox w-5 h-5 text-blue-600">
                        <div class="ml-4">
                            <img src="{{ !empty($item['gambar']) ? asset('storage/' . $item['gambar']) : asset('storage/default.png') }}"
                                 alt="{{ $item['nama'] }}" class="w-24 h-24 rounded-lg object-cover">
                        </div>
                        <div class="flex-1 ml-4 relative">
                            {{-- Harga --}}
                            <div class="absolute top-3 right-4 text-base font-bold text-gray-800">
                                Rp {{ number_format($item['harga'], 0, ',', '.') }}
                            </div>

                            {{-- Nama --}}
                            <h2 class="text-[19px] font-bold text-gray-800 mb-2">{{ $item['nama'] }}</h2>

                            {{-- Kontrol Jumlah + Hapus --}}
                            <div class="flex items-center gap-1">
                                <div class="flex items-center border border-gray-300 rounded-full px-2 h-10">
                                    <button type="button" onclick="ubahJumlah('{{ $id }}', 'kurang')" class="px-3">-</button>
                                    <span class="jumlah px-4">{{ $item['jumlah'] }}</span>
                                    <button type="button" onclick="ubahJumlah('{{ $id }}', 'tambah')" class="px-3">+</button>
                                </div>
                                <form onsubmit="return animateRemoveItem(event, '{{ $id }}')" class="ml-2">
                                    @csrf
                                    <button type="submit" class="text-red-600 hover:text-red-800">🗑️</button>
                                </form>
                            </div>

                            {{-- Subtotal per produk --}}
                            <div class="mt-2 text-sm text-gray-600 font-medium">
                                Total: Rp <span class="subtotal">{{ number_format($item['harga'] * $item['jumlah'], 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Total Keseluruhan + Checkout --}}
        <div class="bg-white p-6 rounded-lg shadow mt-6">
            <div class="text-lg font-semibold text-gray-800">
                Total Semua: Rp <span id="total-harga">0</span>
            </div>
            <form action="{{ route('keranjang.update') }}" method="POST" class="mt-4">
                @csrf
                <button type="submit" class="bg-sky-600 hover:bg-sky-700 text-white px-6 py-3 rounded-full text-lg font-semibold">
                    Checkout Sekarang
                </button>
            </form>
        </div>
    @else
        <p class="text-center text-gray-500">Keranjang belanja kamu kosong.</p>
    @endif
</div>
@endsection

@push('scripts')
<script>
function ubahJumlah(id, aksi) {
    const card = document.querySelector(`[data-id="${id}"]`);
    const jumlahSpan = card.querySelector('.jumlah');
    let jumlah = parseInt(jumlahSpan.innerText);

    if (aksi === 'tambah') jumlah++;
    else if (aksi === 'kurang' && jumlah > 1) jumlah--;

    jumlahSpan.innerText = jumlah;

    // Update subtotal per produk
    const hargaText = card.querySelector('.absolute.top-3.right-4').innerText.replace(/[Rp. ]/g, '');
    const harga = parseInt(hargaText);
    const subtotalElem = card.querySelector('.subtotal');
    subtotalElem.innerText = (harga * jumlah).toLocaleString('id-ID');

    updateTotal();
}

function updateTotal() {
    let total = 0;
    document.querySelectorAll('#keranjang-list > div').forEach(card => {
        if (card.querySelector('.item-checkbox').checked) {
            const hargaText = card.querySelector('.absolute.top-3.right-4').innerText.replace(/[Rp. ]/g, '');
            const harga = parseInt(hargaText);
            const jumlah = parseInt(card.querySelector('.jumlah').innerText);
            total += harga * jumlah;
        }
    });
    document.getElementById('total-harga').innerText = total.toLocaleString('id-ID');
}

document.getElementById('pilih-semua').addEventListener('change', function () {
    document.querySelectorAll('.item-checkbox').forEach(cb => cb.checked = this.checked);
    updateJumlahDipilih();
    updateTotal();
});

document.querySelectorAll('.item-checkbox').forEach(cb => {
    cb.addEventListener('change', () => {
        updateJumlahDipilih();
        updateTotal();
    });
});

function updateJumlahDipilih() {
    const selected = document.querySelectorAll('.item-checkbox:checked').length;
    document.getElementById('jumlah-dipilih').innerText = selected;
}

// Animasi Hapus
function animateRemoveItem(e, id) {
    e.preventDefault();
    const card = document.querySelector(`[data-id="${id}"]`);
    card.classList.add('fade-out');
    setTimeout(() => {
        const form = document.createElement('form');
        form.action = `/keranjang/hapus/${id}`;
        form.method = 'POST';

        const csrf = document.createElement('input');
        csrf.type = 'hidden';
        csrf.name = '_token';
        csrf.value = '{{ csrf_token() }}';

        form.appendChild(csrf);
        document.body.appendChild(form);
        form.submit();
    }, 400);
    return false;
}
</script>
@endpush
