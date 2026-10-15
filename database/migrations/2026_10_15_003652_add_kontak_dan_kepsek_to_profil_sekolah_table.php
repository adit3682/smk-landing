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
        Schema::table('profil_sekolah', function (Blueprint $table) {
            if (!Schema::hasColumn('profil_sekolah', 'alamat')) {
                $table->text('alamat')->nullable();
            }
            if (!Schema::hasColumn('profil_sekolah', 'telepon')) {
                $table->string('telepon')->nullable();
            }
            if (!Schema::hasColumn('profil_sekolah', 'email')) {
                $table->string('email')->nullable();
            }
            if (!Schema::hasColumn('profil_sekolah', 'nama_kepala_sekolah')) {
                $table->string('nama_kepala_sekolah')->nullable();
            }
            if (!Schema::hasColumn('profil_sekolah', 'foto_kepala_sekolah')) {
                $table->string('foto_kepala_sekolah')->nullable();
            }
            if (!Schema::hasColumn('profil_sekolah', 'sambutan_kepala_sekolah')) {
                $table->text('sambutan_kepala_sekolah')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // sengaja kosong supaya rollback tidak menghapus data
    }
};