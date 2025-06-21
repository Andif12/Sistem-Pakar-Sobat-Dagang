<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMesinProduksiTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mesin_produksi', function (Blueprint $table) {
            $table->id('id_mesin');
            $table->unsignedBigInteger('id_ikm');
            $table->foreign('id_ikm')->references('id_ikm')->on('data_ikm')->onDelete('cascade');

            $table->string('jenis_mesin');
            $table->string('nama_mesin');
            $table->string('merk_type');
            $table->string('teknologi');
            $table->string('negara_pembuat');
            $table->integer('tahun_perolehan');
            $table->integer('tahun_pembuatan');
            $table->integer('jumlah_unit')->default(1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mesin_produksi');
    }
};
