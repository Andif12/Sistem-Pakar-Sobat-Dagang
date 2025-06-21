<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('rencana_kebutuhan_distributor', function (Blueprint $table) {
            $table->id('id_rancangan'); // Primary Key
            $table->unsignedBigInteger('id_barang_pelaporan')->nullable(); // Foreign Key
            $table->year('tahun');
            $table->integer('jumlah');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('id_barang_pelaporan')
                ->references('id_barang_pelaporan')
                ->on('barang_pelaporan')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rencana_kebutuhan_distributor');
    }
};
