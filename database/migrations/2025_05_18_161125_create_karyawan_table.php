<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKaryawanTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('karyawan', function (Blueprint $table) {
            $table->id('id_karyawan');
            $table->unsignedBigInteger('id_ikm');
            $table->foreign('id_ikm')->references('id_ikm')->on('data_ikm')->onDelete('cascade');

            // Status & Gender
            $table->integer('tenaga_kerja_tetap');
            $table->integer('tenaga_kerja_tidak_tetap');
            $table->integer('tenaga_kerja_laki_laki');
            $table->integer('tenaga_kerja_perempuan');

            // Pendidikan
            $table->integer('sd');
            $table->integer('smp');
            $table->integer('sma_smk');
            $table->integer('d1_d3');
            $table->integer('s1_d4');
            $table->integer('s2');
            $table->integer('s3');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karyawan');
    }
};
