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
        Schema::table('users', function (Blueprint $table) {
            // Kita tambahkan kolom 'xp' (angka bulat)
            // Default nilainya 0 (karena user baru belum punya poin)
            // 'after email' artinya kolom ini ditaruh setelah kolom email biar rapi
            $table->integer('xp')->default(0)->after('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Kalau migrasi dibatalkan (rollback), hapus kolom xp
            $table->dropColumn('xp');
        });
    }
};