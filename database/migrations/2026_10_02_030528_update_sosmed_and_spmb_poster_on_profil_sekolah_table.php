<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profil_sekolah', function (Blueprint $table) {
            if (Schema::hasColumn('profil_sekolah', 'facebook')) {
                $table->dropColumn('facebook');
            }
            if (Schema::hasColumn('profil_sekolah', 'linkedin')) {
                $table->dropColumn('linkedin');
            }
            if (Schema::hasColumn('profil_sekolah', 'spmb_poster')) {
                $table->dropColumn('spmb_poster');
            }
            if (!Schema::hasColumn('profil_sekolah', 'instagram')) {
                $table->string('instagram')->nullable();
            }
            if (!Schema::hasColumn('profil_sekolah', 'tiktok')) {
                $table->string('tiktok')->nullable()->after('instagram');
            }
            if (!Schema::hasColumn('profil_sekolah', 'spmb_posters')) {
                $table->json('spmb_posters')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('profil_sekolah', function (Blueprint $table) {
            if (Schema::hasColumn('profil_sekolah', 'tiktok')) {
                $table->dropColumn('tiktok');
            }
            if (Schema::hasColumn('profil_sekolah', 'spmb_posters')) {
                $table->dropColumn('spmb_posters');
            }
        });
    }
};