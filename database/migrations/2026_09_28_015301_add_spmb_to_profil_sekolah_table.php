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
         Schema::table('profil_sekolah', function (Blueprint $table) { $table->string('spmb_poster')
         ->nullable(); $table->string('spmb_link')
         ->nullable(); $table->string('spmb_whatsapp')
         ->nullable(); }); 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table('profil_sekolah', function (Blueprint $table) { $table->dropColumn(['spmb_poster', 'spmb_link', 'spmb_whatsapp']); 
         });
    }
};
