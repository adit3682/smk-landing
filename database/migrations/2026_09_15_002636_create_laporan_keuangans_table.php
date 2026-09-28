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
    Schema::create('laporan_keuangans', function (Blueprint $table) {
        $table->id();
        $table->string('judul');
        $table->string('periode')->nullable();
        $table->year('tahun');
        $table->string('tahap')->nullable();
        $table->string('sumber_dana')->nullable();
        $table->string('gambar')->nullable();
        $table->string('file_pdf')->nullable();
        $table->text('keterangan')->nullable();
        $table->integer('urutan')->default(0);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_keuangans');
    }
};
