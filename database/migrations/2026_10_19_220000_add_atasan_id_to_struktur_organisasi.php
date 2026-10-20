<?php

use App\Models\StrukturOrganisasi;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $tabel = (new StrukturOrganisasi)->getTable();

        if (!Schema::hasColumn($tabel, 'atasan_id')) {
            Schema::table($tabel, function (Blueprint $table) {
                $table->unsignedBigInteger('atasan_id')->nullable();
            });
        }
    }

    public function down(): void
    {
        // Tidak menghapus kolom saat rollback.
    }
};