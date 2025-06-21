<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('barang_pelaporan', function (Blueprint $table) {
            $table->id('id_barang_pelaporan'); // Primary Key
            $table->unsignedBigInteger('id_kategori_barang_pelaporan'); // Foreign Key
            $table->string('nama_barang');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('id_kategori_barang_pelaporan')->references('id_kategori_barang_pelaporan')->on('kategori_barang_pelaporan')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barang_pelaporan');
    }
};
