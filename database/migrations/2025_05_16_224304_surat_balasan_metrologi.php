<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('surat_keluar_metrologi', function (Blueprint $table) {
            $table->string('id_surat_balasan')->primary();
            $table->string('id_surat');
            $table->string('tanggal');
            $table->string('path_dokumen')->nullable();
            $table->text('isi_surat')->nullable();
            $table->enum('status_surat_keluar', ['Menunggu', 'Disetujui', 'Ditolak', 'Draft'])->default('Menunggu');
            $table->enum('status_kepalaBidang', ['Menunggu', 'Disetujui', 'Ditolak', 'Draft'])->default('Menunggu');
            $table->enum('status_kadis', ['Menunggu', 'Disetujui', 'Ditolak'])->default('Menunggu');
            $table->text('keterangan_kadis')->nullable();
            $table->timestamps();

            $table->foreign('id_surat')->references('id_surat')->on('surat_metrologi')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_keluar_metrologi');
    }
};
