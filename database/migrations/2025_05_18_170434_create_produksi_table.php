<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduksiTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('produksi', function (Blueprint $table) {
            $table->id('id_produksi');
            $table->unsignedBigInteger('id_ikm');
            $table->foreign('id_ikm')->references('id_ikm')->on('data_ikm')->onDelete('cascade');

            $table->string('jenis_produksi');
            $table->string('kbli');
            $table->string('kode_hs');
            $table->string('spesifikasi');
            $table->float('banyaknya')->default(0);
            $table->bigInteger('nilai')->default(0);
            $table->string('satuan');
            $table->float('presentase_produk_ekspor')->default(0);
            $table->string('negara_tujuan_ekspor')->nullable();
            $table->integer('kapasitas_terpasang_per_tahun')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produksi');
    }
};
