<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengeluaranTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengeluaran', function (Blueprint $table) {
            $table->id('id_pengeluaran');
            $table->unsignedBigInteger('id_ikm');
            $table->foreign('id_ikm')->references('id_ikm')->on('data_ikm')->onDelete('cascade');

            $table->bigInteger('upah_gaji')->default(0);
            $table->bigInteger('pengeluaran_industri_distribusi')->default(0);
            $table->bigInteger('pengeluaran_rnd')->default(0);
            $table->bigInteger('pengeluaran_tanah')->default(0);
            $table->bigInteger('pengeluaran_gedung')->default(0);
            $table->bigInteger('pengeluaran_mesin')->default(0);
            $table->bigInteger('lainnya')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengeluaran');
    }
};
