<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jurusans', function (Blueprint $table) {
            if (!Schema::hasColumn('jurusans', 'keterampilan')) {
                $table->text('keterampilan')->nullable()->after('kurikulum');
            }
        });

        Schema::create('jurusan_kegiatans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jurusan_id')->constrained()->cascadeOnDelete();
            $table->string('kategori'); // KI, Outing Class, PKL, Lainnya
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->string('foto')->nullable();
            $table->date('tanggal')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jurusan_kegiatans');
        Schema::table('jurusans', function (Blueprint $table) {
            if (Schema::hasColumn('jurusans', 'keterampilan')) {
                $table->dropColumn('keterampilan');
            }
        });
    }
};