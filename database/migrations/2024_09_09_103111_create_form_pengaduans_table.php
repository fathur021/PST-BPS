<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('form_pengaduans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->text('alamat')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('email')->nullable();
            $table->text('rincian_informasi')->nullable();
            $table->text('tujuan_penggunaan_informasi')->nullable();
            $table->string('cara_memperoleh_informasi')->nullable();
            $table->string('cara_mendapatkan_salinan_informasi')->nullable();
            $table->string('bukti_identitas_diri_path')->nullable(); // For file path storage
            $table->string('dokumen_pernyataan_keberatan_atas_permohonan_informasi_path')->nullable(); // For file path storage
            $table->string('dokumen_permintaan_informasi_publik_path')->nullable(); // For file path storage
            $table->text('tanda_tangan')->nullable(); // For storing base64 or other signature data
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_pengaduans');
    }
};
