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
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap')->nullable();
            $table->foreignId('petugas_pst')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('front_office')->nullable()->constrained('users')->onDelete('set null');
            $table->integer('kepuasan_petugas_pst')->nullable();
            $table->integer('kepuasan_petugas_front_office')->nullable();
            $table->integer('kepuasan_sarana_prasarana')->nullable();
            $table->text('kritik_saran')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('guest_books', function (Blueprint $table) {
            $table->dropForeign(['petugas_pst']);
            $table->dropForeign(['front_office']);
        });
        Schema::dropIfExists('feedbacks');
    }
};
