<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentUserTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('document_user', function (Blueprint $table) {
            $table->id('id_document');
            $table->uuid('id_permohonan');
            $table->foreign('id_permohonan')
                ->references('id_permohonan')
                ->on('form_permohonan')
                ->onDelete('cascade');

            $table->string('npwp')->nullable();
            $table->string('akta_perusahaan')->nullable();
            $table->string('foto_ktp')->nullable();
            $table->string('foto_usaha')->nullable();
            $table->string('dokument_nib')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_user');
    }
}
