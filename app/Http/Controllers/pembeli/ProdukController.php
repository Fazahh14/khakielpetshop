<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;

class ProdukController extends Controller
{
    // Menampilkan daftar produk dengan filter kategori dan pencarian
    public function index(Request $request)
    {
        // Mulai query produk
        $query = Produk::query();

        // Filter berdasarkan kategori jika ada
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // Filter berdasarkan pencarian nama produk jika ada
        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        // Ambil semua produk yang sesuai filter dan urutkan dari terbaru
        $produk = $query->latest()->get();

        return view('pembeli.produk.index', compact('produk'));
    }

    // Menampilkan detail produk
    public function show($id)
    {
        $produk = Produk::findOrFail($id);

        return view('pembeli.produk.show', compact('produk'));
    }
}
