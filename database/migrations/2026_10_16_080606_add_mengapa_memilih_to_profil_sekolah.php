<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profil_sekolah', function (Blueprint $table) {
            if (!Schema::hasColumn('profil_sekolah', 'foto_background_hero')) {
                $table->string('foto_background_hero')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('profil_sekolah', function (Blueprint $table) {
            if (Schema::hasColumn('profil_sekolah', 'foto_background_hero')) {
                $table->dropColumn('foto_background_hero');
            }
        });
    }
};