<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $table = 'barangs';

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'harga_jual',
        'harga_beli',
        'satuan',
        'stok',
        'kategori',
        'stok',
    ];

    public function penjualan()
    {
        return $this->hasMany(Penjualan::class);
    }
}
