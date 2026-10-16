
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $kolom = [
            'spmb_tahun_ajaran'       => 'string',
            'spmb_biaya'              => 'string',
            'spmb_promo'              => 'string',
            'persyaratan_pendaftaran' => 'text',
            'ekstrakurikuler'         => 'text',
            'spmb_gelombang'          => 'text',
            'spmb_prestasi'           => 'text',
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
