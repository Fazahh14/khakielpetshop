<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KeranjangPembeliController extends Controller
{
    public function index()
    {
        $keranjang = session('keranjang', []);

        $total = collect($keranjang)->reduce(function ($carry, $item) {
            return $carry + ($item['harga'] * $item['jumlah']);
        }, 0);

        return view('pembeli.keranjangBelanja.index', compact('keranjang', 'total'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|integer',
            'nama' => 'required|string',
            'harga' => 'required|numeric',
            'jumlah' => 'required|integer|min:1',
            'gambar' => 'nullable|string',
        ]);

        $keranjang = session()->get('keranjang', []);

        if (isset($keranjang[$validated['id']])) {
            $keranjang[$validated['id']]['jumlah'] += $validated['jumlah'];
        } else {
            $keranjang[$validated['id']] = [
                'nama' => $validated['nama'],
                'harga' => $validated['harga'],
                'jumlah' => $validated['jumlah'],
                'gambar' => $validated['gambar'] ?? null,
            ];
        }

        session()->put('keranjang', $keranjang);

        return redirect()->route('keranjang.index')->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function tambah($id)
    {
        $keranjang = session('keranjang', []);
        if (isset($keranjang[$id])) {
            $keranjang[$id]['jumlah']++;
            session()->put('keranjang', $keranjang);
        }
        return redirect()->route('keranjang.index');
    }

    public function kurang($id)
    {
        $keranjang = session('keranjang', []);
        if (isset($keranjang[$id])) {
            $keranjang[$id]['jumlah']--;
            if ($keranjang[$id]['jumlah'] <= 0) {
                unset($keranjang[$id]);
            }
            session()->put('keranjang', $keranjang);
        }
        return redirect()->route('keranjang.index');
    }

    public function hapus($id)
    {
        $keranjang = session('keranjang', []);
        if (isset($keranjang[$id])) {
            unset($keranjang[$id]);
            session()->put('keranjang', $keranjang);
        }
        return redirect()->route('keranjang.index');
    }

    public function update(Request $request)
    {
        $checked = $request->input('checked_items', []);
        $keranjang = session('keranjang', []);
        $total = 0;

        foreach ($checked as $id) {
            if (isset($keranjang[$id])) {
                $total += $keranjang[$id]['harga'] * $keranjang[$id]['jumlah'];
            }
        }

        return back()->with('success', 'Checkout berhasil. Total: Rp ' . number_format($total, 0, ',', '.'));
    }

    public function hapusAjax(Request $request)
    {
        $id = $request->input('id');
        $keranjang = session('keranjang', []);
        if (isset($keranjang[$id])) {
            unset($keranjang[$id]);
            session()->put('keranjang', $keranjang);
        }
        return response()->json(['success' => true]);
    }
}
