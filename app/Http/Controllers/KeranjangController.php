<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keranjang;
use App\Models\Barang;
use DataTables;
use DB;

class KeranjangController extends Controller
{
    public function index()
    {
        $keranjangItems = Keranjang::with('barang')->get();
        return DataTables::of($keranjangItems)
            ->addColumn('barang.kode_barang', function ($row) {
                return $row->barang->kode_barang;
            })
            ->addColumn('barang.nama_barang', function ($row) {
                return $row->barang->nama_barang;
            })
            ->addColumn('action', function ($row) {
                return '<button class="btn btn-danger" onclick="removeFromCart(' . $row->id . ')">Remove</button>';
            })
            ->make(true);
    }

    public function store(Request $request)
    {
        $barang = Barang::find($request->barang_id);
        if (!$barang || $barang->stok <= 0) {
            return response()->json(['error' => 'Barang tidak ditemukan atau stok habis'], 400);
        }

        $keranjangItem = Keranjang::where('barang_id', $barang->id)->first();
        if ($keranjangItem) {
            $keranjangItem->jumlah += $request->jumlah;
            $keranjangItem->total_harga = $keranjangItem->jumlah * $keranjangItem->harga_satuan;
            $keranjangItem->save();
        } else {
            $keranjangItem = Keranjang::create([
                'barang_id' => $barang->id,
                'jumlah' => $request->jumlah,
                'harga_satuan' => $barang->harga_jual,
                'total_harga' => $barang->harga_jual * $request->jumlah,
            ]);
        }

        return response()->json(['success' => 'Barang berhasil ditambahkan ke keranjang', 'keranjang' => $keranjangItem]);
    }

    public function destroy($id)
    {
        $keranjangItem = Keranjang::find($id);
        if (!$keranjangItem) {
            return response()->json(['error' => 'Item tidak ditemukan'], 404);
        }

        $keranjangItem->delete();
        return response()->json(['success' => 'Item berhasil dihapus']);
    }
}
