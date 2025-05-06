<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use Midtrans\Snap;
use Midtrans\Config;

class CheckoutController extends Controller
{
    /**
     * Simpan produk ke session sebelum checkout.
     */
    public function storeProduk(Request $request)
    {
        // Simpan data produk ke session
        session([
            'checkout_produk' => $request->only([
                'id', 'nama', 'harga', 'jumlah', 'gambar'
            ])
        ]);

        return redirect()->route('checkout.form');
    }

    /**
     * Tampilkan form checkout.
     */
    public function form()
    {
        $produk = session('checkout_produk');

        // Cegah akses langsung tanpa data produk
        if (!$produk) {
            return redirect()->route('pembeli.produk.index')
                ->with('error', 'Silakan pilih produk terlebih dahulu.');
        }

        return view('pembeli.checkout.form', compact('produk'));
    }

    /**
     * Proses checkout dan transaksi sesuai metode.
     */
    public function process(Request $request)
    {
        // Ambil produk dari session
        $produk = session('checkout_produk');

        if (!$produk) {
            return redirect()->route('pembeli.produk.index')
                ->with('error', 'Produk tidak ditemukan. Silakan ulangi.');
        }

        // Validasi input user
        $request->validate([
            'nama'    => 'required|string',
            'alamat'  => 'required|string',
            'telepon' => 'required|string',
            'total'   => 'required|numeric|min:1',
            'metode'  => 'required|in:midtrans,cod,dana',
        ]);

        // Generate order ID unik
        $orderId = 'ORDER-' . uniqid();

        // Simpan transaksi ke database
        Transaksi::create([
            'order_id'        => $orderId,
            'nama'            => $request->nama,
            'alamat'          => $request->alamat,
            'telepon'         => $request->telepon,
            'tanggal_pesanan' => now()->toDateString(),
            'total'           => $request->total,
            'status'          => 'pending',
            'metode'          => $request->metode,
        ]);

        // Metode pembayaran menggunakan Midtrans
        if ($request->metode === 'midtrans') {
            // Konfigurasi Midtrans
            Config::$serverKey    = config('midtrans.server_key');
            Config::$isProduction = config('midtrans.is_production');
            Config::$isSanitized  = true;
            Config::$is3ds        = true;

            // Parameter Snap
            $params = [
                'transaction_details' => [
                    'order_id'     => $orderId,
                    'gross_amount' => $request->total,
                ],
                'customer_details' => [
                    'first_name' => $request->nama,
                    'phone'      => $request->telepon,
                    'address'    => $request->alamat,
                ],
                'item_details' => [[
                    'id'       => $produk['id'],
                    'price'    => $produk['harga'],
                    'quantity' => $produk['jumlah'],
                    'name'     => $produk['nama']
                ]],
            ];

            $snapToken = Snap::getSnapToken($params);

            return view('pembeli.checkout.snap', compact('snapToken'));
        }

        // Jika metode selain midtrans (COD/Dana), redirect ke produk
        session()->forget('checkout_produk'); // hapus session setelah selesai

        return redirect()->route('pembeli.produk.index')
            ->with('success', 'Pesanan berhasil dilakukan.');
    }

    /**
     * Callback dari Midtrans untuk update status pembayaran.
     */
    public function callback(Request $request)
    {
        $data = json_decode($request->getContent());

        $transaksi = Transaksi::where('order_id', $data->order_id)->first();

        if ($transaksi) {
            $transaksi->status = $data->transaction_status;
            $transaksi->save();
        }

        return response()->json(['status' => 'ok']);
    }
}
