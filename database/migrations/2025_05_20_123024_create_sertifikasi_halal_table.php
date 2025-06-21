<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sertifikasi_halal', function (Blueprint $table) {
            $table->id('id_halal');
            $table->unsignedBigInteger('id_user')->nullable();
            $table->unsignedBigInteger('id_ikm')->nullable();
            $table->string('nama_usaha');
            $table->text('alamat');
            $table->string('no_sertifikasi_halal');
            $table->date('tanggal_sah');
            $table->date('tanggal_exp');
            $table->string('sertifikat')->nullable();
            $table->string('status');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sertifikasi_halal');
    }
};