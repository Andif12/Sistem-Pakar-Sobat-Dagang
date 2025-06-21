<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListrikTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('listrik', function (Blueprint $table) {
            $table->id('id_listrik');
            $table->unsignedBigInteger('id_ikm');
            $table->foreign('id_ikm')->references('id_ikm')->on('data_ikm')->onDelete('cascade');

            $table->string('sumber');       // e.g. pln, non_pln, pembangkit_sendiri
            $table->float('banyaknya')->default(0);   // dalam kWh
            $table->bigInteger('nilai')->default(0);  // nilai dalam Rp
            $table->string('peruntukkan');  // e.g. mesin produksi, penerangan

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listrik');
    }
};