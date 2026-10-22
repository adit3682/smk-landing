<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('profil_sekolah', 'spmb_brosur_pdf')) {
            Schema::table('profil_sekolah', function (Blueprint $table) {
                $table->string('spmb_brosur_pdf')->nullable();
            });
        }
    }

    public function down(): void
    {
        // Tidak menghapus kolom saat rollback.
    }
};