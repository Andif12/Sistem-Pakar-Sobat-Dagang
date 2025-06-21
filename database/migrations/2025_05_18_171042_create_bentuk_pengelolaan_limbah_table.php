<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBentukPengelolaanLimbahTable extends Migration
{
    public function up(): void
    {
        Schema::create('bentuk_pengelolaan_limbah', function (Blueprint $table) {
            $table->id('id_bentuk');
            $table->unsignedBigInteger('id_ikm');
            $table->foreign('id_ikm')->references('id_ikm')->on('data_ikm')->onDelete('cascade');

            // Limbah padat
            $table->string('jenis_limbah')->nullable();
            $table->float('jumlah_limbah')->default(0);

            // Limbah B3
            $table->string('jenis_limbah_b3')->nullable();
            $table->float('jumlah_limbah_b3')->default(0);
            $table->string('tps_limbah_b3')->nullable();

            // Kerja sama dan internal
            $table->string('pihak_berizin')->nullable();
            $table->string('internal_industri')->nullable();

            // Limbah cair
            $table->string('parameter_limbah_cair')->nullable();
            $table->float('jumlah_limbah_cair')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bentuk_pengelolaan_limbah');
    }
}

