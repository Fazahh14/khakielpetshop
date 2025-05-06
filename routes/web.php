<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Middleware\RedirectIfNotBuyer;
use App\Http\Middleware\RedirectIfNotSeller;
use App\Http\Controllers\Admin\AkunController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\ArtikelController;
use App\Http\Controllers\Admin\KelolaStatusPesananController;
use App\Http\Controllers\Admin\Produk\MakananKucingController;
use App\Http\Controllers\Admin\Produk\AksesorisController;
use App\Http\Controllers\Admin\Produk\ObatObatanController;
use App\Http\Controllers\Admin\Produk\PerlengkapanController;
use App\Http\Controllers\Admin\Produk\VitaminKucingController;
use App\Http\Controllers\Pembeli\ProdukController;
use App\Http\Controllers\Pembeli\KeranjangPembeliController;
use App\Http\Controllers\Pembeli\CheckoutController;

// =============================
// Halaman Awal
// =============================
Route::get('/', fn () => redirect()->route('pembeli.produk.index'));

// =============================
// Autentikasi
// =============================
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// =============================
// Produk (Publik / Guest & Auth)
// =============================
Route::get('/produk', [ProdukController::class, 'index'])->name('pembeli.produk.index');
Route::get('/produk/{id}', [ProdukController::class, 'show'])->name('pembeli.produk.show');

// =============================
// Pembeli (User Role: buyer)
// =============================
Route::middleware(['auth', RedirectIfNotBuyer::class])->group(function () {
    // Dashboard pembeli
    Route::get('/dashboard', fn () => redirect()->route('pembeli.produk.index'))->name('pembeli.dashboard');

    // Keranjang Belanja
    Route::prefix('keranjang')->name('keranjang.')->group(function () {
        Route::get('/', [KeranjangPembeliController::class, 'index'])->name('index');
        Route::post('/', [KeranjangPembeliController::class, 'store'])->name('store');
        Route::post('/tambah/{id}', [KeranjangPembeliController::class, 'tambah'])->name('tambah');
        Route::post('/kurang/{id}', [KeranjangPembeliController::class, 'kurang'])->name('kurang');
        Route::post('/hapus/{id}', [KeranjangPembeliController::class, 'hapus'])->name('hapus');
        Route::post('/update', [KeranjangPembeliController::class, 'update'])->name('update');
    });

    // =============================
    // Checkout & Pembayaran via Midtrans
    // =============================
    Route::post('/checkout/store-produk', [CheckoutController::class, 'storeProduk'])->name('checkout.storeProduk');
    Route::get('/checkout', [CheckoutController::class, 'form'])->name('checkout.form');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::post('/midtrans/callback', [CheckoutController::class, 'callback']);
});

// =============================
// Admin / Seller
// =============================
Route::middleware(['auth', RedirectIfNotSeller::class])->group(function () {
    Route::get('/akun', [AkunController::class, 'index'])->name('akun.index');
    Route::resource('akun', AkunController::class)->except(['index']);

    Route::get('/laporan/penjualan', [LaporanController::class, 'index'])->name('laporan.penjualan');
    Route::get('/admin/produk', fn () => view('admin.produk.index'))->name('produk.kelolaProduk');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('artikel', ArtikelController::class)->names('artikel');
    });

    // Produk berdasarkan kategori
    Route::resource('admin/produk/makanan-kucing', MakananKucingController::class)->names('makanan-kucing');
    Route::resource('admin/produk/aksesoris', AksesorisController::class)->names('aksesoris');
    Route::resource('admin/produk/obat-obatan', ObatObatanController::class)->names('obat-obatan');
    Route::resource('admin/produk/perlengkapan', PerlengkapanController::class)->names('perlengkapan');
    Route::resource('admin/produk/vitamin-kucing', VitaminKucingController::class)->names('vitamin-kucing');

    // Status Pesanan
    Route::get('/admin/status-pesanan', [KelolaStatusPesananController::class, 'index'])->name('kelolastatuspesanan.index');
    Route::get('/admin/status-pesanan/{id}/edit', [KelolaStatusPesananController::class, 'edit'])->name('kelolastatuspesanan.edit');
    Route::put('/admin/status-pesanan/{id}', [KelolaStatusPesananController::class, 'update'])->name('kelolastatuspesanan.update');
});

// =============================
// Fallback
// =============================
Route::get('/status', fn () => redirect()->route('pembeli.produk.index'))->name('status');
