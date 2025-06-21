<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataIkmTable extends Migration
{
    public function up()
    {
        Schema::create('data_ikm', function (Blueprint $table) {
            $table->id('id_ikm');

            $table->string('nama_ikm');
            $table->string('luas');
            $table->string('nama_pemilik');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);

            $table->string('kecamatan');
            $table->string('kelurahan');

            $table->string('komoditi');
            $table->string('jenis_industri');

            $table->text('alamat');
            $table->string('nib');
            $table->string('no_telp', 20);
            $table->integer('tenaga_kerja');
            $table->bigInteger('level')->default(0);


            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('data_ikm');
    }
}
