<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profil_sekolah', function (Blueprint $table) {
            if (!Schema::hasColumn('profil_sekolah', 'telepon')) {
                $table->string('telepon')->nullable();
            }
            if (!Schema::hasColumn('profil_sekolah', 'email')) {
                $table->string('email')->nullable();
            }
            if (!Schema::hasColumn('profil_sekolah', 'foto_kepala_sekolah')) {
                $table->string('foto_kepala_sekolah')->nullable();
            }
            if (!Schema::hasColumn('profil_sekolah', 'sambutan_kepala_sekolah')) {
                $table->text('sambutan_kepala_sekolah')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('profil_sekolah', function (Blueprint $table) {
            foreach (['telepon', 'email', 'foto_kepala_sekolah', 'sambutan_kepala_sekolah'] as $col) {
                if (Schema::hasColumn('profil_sekolah', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};