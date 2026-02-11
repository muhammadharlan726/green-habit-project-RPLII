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
    Schema::table('missions', function (Blueprint $table) {
        // Kolom boolean: 0 = Ringan (Gak perlu foto), 1 = Berat (Wajib foto)
        $table->boolean('requires_evidence')->default(false)->after('points_reward');
    });
}

    public function down(): void
{
    Schema::table('missions', function (Blueprint $table) {
        $table->dropColumn('requires_evidence');
    });
}
};
