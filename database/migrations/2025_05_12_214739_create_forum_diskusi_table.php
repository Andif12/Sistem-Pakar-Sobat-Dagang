<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForumDiskusiTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('forum_diskusi', function (Blueprint $table) {
            $table->id('id_pengaduan');
            $table->unsignedBigInteger('id_user')->nullable();
            $table->unsignedBigInteger('id_disdag')->nullable();
            $table->text('chat');
            $table->timestamp('waktu');
            $table->string('status');

            // kolom timestamps otomatis membuat created_at dan updated_at
            $table->timestamps();

            $table->foreign('id_user')->references('id_user')->on('user')->onDelete('cascade');
            $table->foreign('id_disdag')->references('id_disdag')->on('disdag')->onDelete('cascade');
        });
    }


    public function down()
    {
        Schema::dropIfExists('forum_diskusi');
    }
}
