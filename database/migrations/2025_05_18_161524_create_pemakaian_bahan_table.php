<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePemakaianBahanTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pemakaian_bahan', function (Blueprint $table) {
            $table->id('id_pemakaian_bahan');
            $table->unsignedBigInteger('id_ikm');
            $table->foreign('id_ikm')->references('id_ikm')->on('data_ikm')->onDelete('cascade');

            $table->string('nama_bahan');             // Contoh: Kapas
            $table->string('jenis_bahan');            // Bahan Baku / Penolong
            $table->string('spesifikasi');            // Misal: Kualitas A
            $table->string('kode_hs');                // Kode Harmonized System
            $table->string('satuan_standar');         // kg, liter, pcs, dll

            $table->integer('jumlah_dalam_negeri');   // Jumlah dalam unit
            $table->bigInteger('nilai_dalam_negeri'); // Nilai dalam rupiah

            $table->integer('jumlah_impor');          // Jumlah dalam unit
            $table->bigInteger('nilai_impor');
            $table->string('negara_asal_impor');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemakaian_bahan');
    }
};
