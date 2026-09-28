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
        Schema::create('profil_sekolah', function (Blueprint $table) {
    $table->id();
    $table->string('nama_sekolah');
    $table->string('npsn')->nullable();
    $table->text('alamat')->nullable();
    $table->string('kode_pos')->nullable();
    $table->string('nama_kepala_sekolah')->nullable();
    $table->text('visi')->nullable();
    $table->json('misi')->nullable();
    $table->text('profil_yayasan')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profil_sekolah');
    }
};
