<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUttpTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('uttp', function (Blueprint $table) {
            $table->id('id_uttp'); // Primary key
            $table->unsignedBigInteger('id_user')->nullable();
            $table->foreign('id_user')->references('id_user')->on('user')->onDelete('cascade');
            
            $table->date('tanggal_penginputan')->nullable();
            $table->string('no_registrasi')->nullable();
            $table->string('nama_usaha')->nullable();
            $table->string('jenis_alat')->nullable();
            $table->string('nama_alat')->nullable();
            $table->string('merk_type')->nullable();
            $table->string('nomor_seri')->nullable();
            $table->integer('jumlah_alat')->nullable();
            $table->string('alat_penguji')->nullable();
            $table->string('ctt')->nullable();
            $table->string('spt_keperluan')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->string('terapan')->nullable();
            $table->text('keterangan')->nullable();
            $table->string('sertifikat_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uttp');
    }
};
