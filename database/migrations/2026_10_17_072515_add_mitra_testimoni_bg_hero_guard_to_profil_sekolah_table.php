<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profil_sekolah', function (Blueprint $table) {
            if (!Schema::hasColumn('profil_sekolah', 'spmb_mitra')) {
                $table->text('spmb_mitra')->nullable();
            }
            if (!Schema::hasColumn('profil_sekolah', 'spmb_testimoni')) {
                $table->text('spmb_testimoni')->nullable();
            }
            if (!Schema::hasColumn('profil_sekolah', 'foto_background_hero')) {
                $table->string('foto_background_hero')->nullable();
            }
        });
    }

    public function down(): void
    {
        // dikosongkan
    }
};