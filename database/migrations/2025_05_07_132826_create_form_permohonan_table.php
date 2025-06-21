    <?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormPermohonanTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('form_permohonan', function (Blueprint $table) {
            $table->uuid('id_permohonan')->primary();
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')->references('id_user')->on('user')->onDelete('cascade');

            // Atribut lainnya
            $table->string('kecamatan');
            $table->string('kelurahan');
            $table->date('tgl_pengajuan');
            $table->string('jenis_surat');
            $table->string('titik_koordinat');
            $table->string('file_surat')->nullable();
            $table->string('file_balasan')->nullable();
            $table->enum('status', ['menunggu', 'ditolak', 'diterima', 'disimpan'])->default('menunggu');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_permohonan');
    }
}
