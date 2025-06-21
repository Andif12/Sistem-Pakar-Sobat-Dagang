<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeritaTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('berita', function (Blueprint $table) {
            $table->id('id_berita'); // Primary Key
            $table->unsignedBigInteger('id_disdag')->nullable(); // Foreign Key
            $table->string('judul');
            $table->text('isi');
            $table->string('lampiran')->nullable(); // file attachment (bisa kosong)
            $table->date('tanggal'); // Tanggal berita
            $table->timestamps();

            // Set foreign key constraint
            $table->foreign('id_disdag')
                ->references('id_disdag')
                ->on('disdag')
                ->onDelete('cascade'); // Kalau admin dihapus, beritanya juga dihapus otomatis
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berita');
    }
}
