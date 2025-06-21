<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenggunaanAirTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('penggunaan_air', function (Blueprint $table) {
            $table->id('id_air');
            $table->unsignedBigInteger('id_ikm');
            $table->foreign('id_ikm')->references('id_ikm')->on('data_ikm')->onDelete('cascade');

            $table->string('sumber_air'); 
            $table->float('banyaknya_penggunaan_m3')->default(0);
            $table->bigInteger('biaya')->default(0); 

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penggunaan_air');
    }
};
