<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stok_opname', function (Blueprint $table) {
            $table->id('id_stok_opname'); // Primary Key

            // Foreign Key ke distributor
            $table->unsignedBigInteger('id_distributor');
            $table->foreign('id_distributor')->references('id_distributor')->on('distributor')->onDelete('cascade');

            // Foreign Key ke toko
            $table->unsignedBigInteger('id_toko');
            $table->foreign('id_toko')->references('id_toko')->on('toko')->onDelete('cascade');

            // Atribut
            $table->integer('stok_awal');
            $table->integer('penyaluran');
            $table->integer('stok_akhir');
            $table->date('tanggal');
            $table->text('nama_barang');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stok_opname');
    }
};
