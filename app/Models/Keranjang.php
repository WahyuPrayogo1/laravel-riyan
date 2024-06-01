<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    use HasFactory;
    protected $fillable = [
        'barang_id', 'jumlah', 'harga_satuan', 'total_harga'
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
