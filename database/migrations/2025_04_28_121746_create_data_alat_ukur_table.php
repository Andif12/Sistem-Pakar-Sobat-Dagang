<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataAlatUkurTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('data_alat_ukur', function (Blueprint $table) {
            $table->id('id_data_alat');
            $table->unsignedBigInteger('id_uttp');
            $table->foreign('id_uttp')->references('id_uttp')->on('uttp')->onDelete('cascade');
            $table->date('tanggal_exp');
            $table->boolean('notifikasi_terkirim')->default(false);
            $table->string('status');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_alat_ukur');
    }
};
