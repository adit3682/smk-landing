<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jurusans', function (Blueprint $table) {
            if (!Schema::hasColumn('jurusans', 'foto_utama')) {
                $table->string('foto_utama')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('jurusans', function (Blueprint $table) {
            if (Schema::hasColumn('jurusans', 'foto_utama')) {
                $table->dropColumn('foto_utama');
            }
        });
    }
};