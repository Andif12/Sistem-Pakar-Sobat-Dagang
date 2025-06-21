<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDisdagTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('disdag', function (Blueprint $table) {
            $table->id('id_disdag'); // Primary Key
            $table->string('password');
            $table->string('nip')->unique();
            $table->string('email')->unique();
            $table->string('telp')->nullable();
            $table->enum('role', [
                'master_admin',
                'admin_perdagangan',
                'admin_industri',
                'admin_metrologi',
                'kabid_perdagangan',
                'kabid_industri',
                'kabid_metrologi',
                'kepala_dinas'
            ]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disdag');
    }
}
