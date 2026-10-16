<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profil_sekolah', function (Blueprint $table) {
            if (!Schema::hasColumn('profil_sekolah', 'spmb_tahun_ajaran')) {
                $table->string('spmb_tahun_ajaran')->nullable();
            }
            if (!Schema::hasColumn('profil_sekolah', 'spmb_biaya')) {
                $table->string('spmb_biaya')->nullable(); // contoh isi: "GRATIS"
            }
            if (!Schema::hasColumn('profil_sekolah', 'spmb_promo')) {
                $table->text('spmb_promo')->nullable(); // contoh: "Dapatkan Spesial Gift untuk 10 Pendaftar Pertama"
            }
            if (!Schema::hasColumn('profil_sekolah', 'persyaratan_pendaftaran')) {
                $table->text('persyaratan_pendaftaran')->nullable(); // 1 baris = 1 item
            }
            if (!Schema::hasColumn('profil_sekolah', 'ekstrakurikuler')) {
                $table->text('ekstrakurikuler')->nullable(); // 1 baris = 1 item
            }
        });
    }

    public function down(): void
    {
        Schema::table('profil_sekolah', function (Blueprint $table) {
            foreach (['spmb_tahun_ajaran', 'spmb_biaya', 'spmb_promo', 'persyaratan_pendaftaran', 'ekstrakurikuler'] as $col) {
                if (Schema::hasColumn('profil_sekolah', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};