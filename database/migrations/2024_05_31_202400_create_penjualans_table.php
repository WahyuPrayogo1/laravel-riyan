<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('penjualans', function (Blueprint $table) {
            $table->id();
            $table->date('tgl_faktur');
            $table->string('no_faktur');
            $table->string('nama_konsumen');
            $table->unsignedBigInteger('barang_id');
            $table->integer('jumlah');
            $table->integer('harga_satuan');
            $table->integer('harga_total');

            $table->foreign('barang_id')->references('id')->on('barangs')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualans');
    }
};
