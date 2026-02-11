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
        // Add frame properties to rewards table
        Schema::table('rewards', function (Blueprint $table) {
            $table->enum('rarity', ['common', 'rare', 'epic', 'legendary'])->default('common')->after('cost');
            $table->string('border_color')->nullable()->after('rarity'); // e.g., #10b981, from-blue-500 to-purple-600
            $table->string('glow_style')->nullable()->after('border_color'); // e.g., shadow-lg, shadow-green-500/50
        });

        // Add active frame to users table
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('active_profile_frame_id')->nullable()->after('avatar')->constrained('rewards')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['active_profile_frame_id']);
            $table->dropColumn('active_profile_frame_id');
        });

        Schema::table('rewards', function (Blueprint $table) {
            $table->dropColumn(['rarity', 'border_color', 'glow_style']);
        });
    }
};
