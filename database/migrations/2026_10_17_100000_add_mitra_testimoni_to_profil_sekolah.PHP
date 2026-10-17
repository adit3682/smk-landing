<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $kolom = [
            'spmb_mitra'     => 'text',
            'spmb_testimoni' => 'text',
        ];

        Schema::table('profil_sekolah', function (Blueprint $table) use ($kolom) {
            foreach ($kolom as $nama => $tipe) {
                if (!Schema::hasColumn('profil_sekolah', $nama)) {
                    $table->{$tipe}($nama)->nullable();
                }
            }
        });
    }

    public function down(): void
    {
        // Tidak menghapus kolom saat rollback.
    }
};