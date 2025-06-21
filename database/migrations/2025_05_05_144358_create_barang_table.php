<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangTable extends Migration
{
    public function up(): void
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->id('id_barang'); // Primary Key
            $table->string('nama_barang'); // Atribut
            $table->unsignedBigInteger('id_index_kategori'); // FK

            // Pastikan foreign key cocok
            $table->foreign('id_index_kategori')
                ->references('id_index_kategori')
                ->on('index_kategori')
                ->onDelete('cascade');

            $table->timestamps(); // created_at & updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barang');
    }
}
