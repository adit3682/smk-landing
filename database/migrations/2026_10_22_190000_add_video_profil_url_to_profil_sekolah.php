<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('profil_sekolah', 'video_profil_url')) {
            Schema::table('profil_sekolah', function (Blueprint $table) {
                $table->string('video_profil_url')->nullable();
            });
        }
    }

    public function down(): void
    {
        // Tidak menghapus kolom saat rollback.
    }
};