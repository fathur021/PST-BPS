<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('regencies', function (Blueprint $table) {
            $table->integer('id')->primary(); // Kolom id bukan auto-increment
            $table->integer('provinsi_id'); // Harus sama tipe datanya dengan id di provinces
            $table->string('name');
            $table->timestamps();
        
            $table->foreign('provinsi_id')->references('id')->on('provinces')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('regencies');
    }
};
