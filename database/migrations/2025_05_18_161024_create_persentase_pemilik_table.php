<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersentasePemilikTable extends Migration
{
    public function up(): void
    {
        Schema::create('persentase_pemilik', function (Blueprint $table) {
            $table->id('id_persentase');
            $table->unsignedBigInteger('id_ikm');
            $table->foreign('id_ikm')->references('id_ikm')->on('data_ikm')->onDelete('cascade');

            $table->decimal('pemerintah_pusat', 5, 2);
            $table->decimal('pemerintah_daerah', 5, 2);
            $table->decimal('swasta_nasional', 5, 2);
            $table->decimal('asing', 5, 2);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('persentase_pemilik');
    }
}
