<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(Barang::select('*'))
                ->addColumn('action', 'layouts.backend.page.barang.tombol')
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('layouts.backend.page.barang.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // Hapus titik dari harga_jual dan harga_beli
        $request->merge([
            'harga_jual' => str_replace('.', '', $request->input('harga_jual')),
            'harga_beli' => str_replace('.', '', $request->input('harga_beli'))
        ]);

        // Validasi data yang sudah diubah
        $validatedData = $request->validate([
            'kode_barang' => 'required|string|unique:barangs,kode_barang,' . $request->id . '|max:255',
            'nama_barang' => 'required|string|max:255',
            'harga_jual' => 'required|integer|min:0',
            'harga_beli' => 'required|integer|min:0',
            'satuan' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
        ]);

        $barangId = $request->id;

        $barang = Barang::updateOrCreate(
            ['id' => $barangId],
            $validatedData
        );

        return response()->json(['success' => 'Record saved successfully', 'data' => $barang]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Barang $barang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $where = array('id' => $request->id);
        $barang  = Barang::where($where)->first();

        return Response()->json($barang);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Barang $barang)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $barang = Barang::where('id', $request->id)->delete();
        if ($barang) {
            return response()->json(['success' => 'Record deleted successfully']);
        }
        return response()->json(['error' => 'Record not found'], 404);
    }
}
