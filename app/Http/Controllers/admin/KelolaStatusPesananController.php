<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StatusPesanan;

class KelolaStatusPesananController extends Controller
{
    public function index()
    {
        $statusPesanan = StatusPesanan::all();
        return view('admin.statuspesanan.index', compact('statusPesanan'));
    }

    public function edit($id)
    {
        $status = StatusPesanan::findOrFail($id);
        return view('admin.statuspesanan.edit', compact('status'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status_pesanan' => 'required|string|max:255'
        ]);

        $status = StatusPesanan::findOrFail($id);
        $status->status_pesanan = $request->status_pesanan;
        $status->save();

        return redirect()->route('kelolastatuspesanan.index')->with('success', 'Status pesanan berhasil diperbarui.');
    }
}
