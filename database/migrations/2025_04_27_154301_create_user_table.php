<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user', function (Blueprint $table) {
            $table->id('id_user'); // Primary Key
            $table->string('kecamatan');
            $table->string('kelurahan');
            $table->string('kabupaten');
            $table->string('password');
            $table->string('nik')->unique();
            $table->string('nib')->nullable();
            $table->string('nama');
            $table->text('alamat_lengkap');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('telp');
            $table->string('email')->unique();
            $table->string('avatar')->nullable()->default('assets/img/profil.jpeg');
            $table->string('verifikasi_token')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user');
    }
}
