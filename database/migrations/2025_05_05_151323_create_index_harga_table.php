<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndexHargaTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('index_harga', function (Blueprint $table) {
            $table->id('id_index'); // Primary Key

            // Foreign key ke tabel barang
            $table->unsignedBigInteger('id_barang');
            $table->foreign('id_barang')->references('id_barang')->on('barang')->onDelete('cascade');

            // Foreign key ke tabel index_kategori
            $table->unsignedBigInteger('id_index_kategori');
            $table->foreign('id_index_kategori')->references('id_index_kategori')->on('index_kategori')->onDelete('cascade');

            // Atribut tambahan
            $table->decimal('harga', 15, 2); // Harga dengan 2 digit desimal
            $table->date('tanggal');
            $table->string('lokasi');

            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('index_harga');
    }
}
