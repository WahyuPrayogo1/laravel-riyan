<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use Illuminate\Http\Request;
use App\Models\Keranjang;
use Illuminate\Support\Facades\DB;
use Exception; // Kelas Exception untuk menangani pengecualian


class PenjualanController extends Controller
{
    public function index()
    {
        return view('layouts.backend.page.penjualan.index');
    }

    public function history()
    {
        if (request()->ajax()) {
            $penjualans = Penjualan::with('barang')->get(); // Pastikan untuk memuat relasi 'barang'
            return datatables()->of($penjualans)
                ->addColumn('nama_barang', function ($row) {
                    return $row->barang ? $row->barang->nama_barang : '-';
                })
                ->rawColumns(['nama_barang'])
                ->make(true);
        }

        return view('layouts.backend.page.history.index');
    }

    public function checkout(Request $request)
    {
    }





    public function create()
    {
        //
    }
    public function show(Penjualan $barang)
    {
        //
    }

    public function store(Request $request)
    {
        // Ambil data keranjang
        $keranjang = Keranjang::with('barang')->get();

        // Validasi keranjang kosong
        if ($keranjang->isEmpty()) {
            return response()->json(['error' => 'Keranjang kosong'], 400);
        }

        // Mulai looping tanpa transaksi
        try {
            foreach ($keranjang as $item) {
                $barang = $item->barang;

                // Validasi stok barang menggunakan constraint database
                if ($barang->stok < $item->jumlah) {
                    throw new \Illuminate\Validation\ValidationException('Stok barang tidak mencukupi');
                }

                // Proses pengurangan stok
                $barang->stok -= $item->jumlah;
                $barang->save();

                // Pembuatan penjualan
                Penjualan::create([
                    'nama_konsumen' => 'wahyu',
                    'no_faktur' => 'F' . now()->format('YmdHis'),
                    'tgl_faktur' => now(),
                    'barang_id' => $barang->id,
                    'jumlah' => $item->jumlah,
                    'harga_satuan' => $item->harga_satuan,
                    'harga_total' => $item->total_harga,
                    'tanggal_penjualan' => now(),
                ]);
            }

            // Bersihkan keranjang
            DB::table('keranjangs')->truncate();

            // Jika operasi berhasil
            return response()->json(['success' => 'Pembelian berhasil']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Tangani kesalahan validasi
            return response()->json(['error' => $e->getMessage()], 422);
        } catch (\Exception $e) {
            // Tangani kesalahan lainnya
            return response()->json(['error' => 'Terjadi kesalahan saat memproses pembelian'], 500);
        }
    }
}
