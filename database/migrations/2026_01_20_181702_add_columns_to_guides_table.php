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
        Schema::table('guides', function (Blueprint $table) {
            if (!Schema::hasColumn('guides', 'title')) {
                $table->string('title')->after('id');
            }
            if (!Schema::hasColumn('guides', 'description')) {
                $table->text('description')->after('title');
            }
            if (!Schema::hasColumn('guides', 'icon')) {
                $table->string('icon')->nullable()->after('description');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('guides', function (Blueprint $table) {
            $table->dropColumn(['title', 'description', 'icon']);
        });
    }
};
