<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('distributor', function (Blueprint $table) {
            $table->id('id_distributor'); // Primary Key
            $table->unsignedBigInteger('id_user'); // Foreign Key
            $table->string('nib');
            $table->enum('status', ['menunggu', 'ditolak', 'diterima'])->default('menunggu');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('id_user')->references('id_user')->on('user')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('distributor');
    }
};
