<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndexKategoriTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('index_kategori', function (Blueprint $table) {
            $table->id('id_index_kategori');       // Primary key
            $table->string('nama_kategori');       // Atribut biasa
            $table->timestamps();                  // Optional: created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('index_kategori');
    }
}
