<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Artikel;
use Illuminate\Support\Facades\Storage;

class ArtikelController extends Controller
{
    public function index()
    {
        $artikel = Artikel::all();
        return view('admin.artikel.index', compact('artikel'));
    }

    public function create()
    {
        return view('admin.artikel.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'gambar' => 'nullable|image|max:2048'
        ]);

        $data = $request->only(['judul', 'konten']);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('artikel', 'public');
        }

        Artikel::create($data);

        // ✅ route diperbaiki
        return redirect()->route('admin.artikel.index')->with('success', 'Artikel berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $artikel = Artikel::findOrFail($id);
        return view('admin.artikel.edit', compact('artikel'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'gambar' => 'nullable|image|max:2048'
        ]);

        $artikel = Artikel::findOrFail($id);
        $data = $request->only(['judul', 'konten']);

        if ($request->hasFile('gambar')) {
            if ($artikel->gambar && Storage::disk('public')->exists($artikel->gambar)) {
                Storage::disk('public')->delete($artikel->gambar);
            }

            $data['gambar'] = $request->file('gambar')->store('artikel', 'public');
        }

        $artikel->update($data);

        // ✅ route diperbaiki
        return redirect()->route('admin.artikel.index')->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $artikel = Artikel::findOrFail($id);

        if ($artikel->gambar && Storage::disk('public')->exists($artikel->gambar)) {
            Storage::disk('public')->delete($artikel->gambar);
        }

        $artikel->delete();

        // ✅ route diperbaiki
        return redirect()->route('admin.artikel.index')->with('success', 'Artikel berhasil dihapus.');
    }
}
