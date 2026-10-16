<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profil_sekolah', function (Blueprint $table) {
            if (!Schema::hasColumn('profil_sekolah', 'foto_mengapa_memilih')) {
                $table->string('foto_mengapa_memilih')->nullable();
            }
            if (!Schema::hasColumn('profil_sekolah', 'mengapa_memilih_teks')) {
                $table->text('mengapa_memilih_teks')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('profil_sekolah', function (Blueprint $table) {
            foreach (['foto_mengapa_memilih', 'mengapa_memilih_teks'] as $col) {
                if (Schema::hasColumn('profil_sekolah', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};