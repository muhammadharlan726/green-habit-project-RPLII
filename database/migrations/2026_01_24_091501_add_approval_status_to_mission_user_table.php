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
        Schema::table('mission_user', function (Blueprint $table) {
            // Change existing status column to include 'pending' and 'approved'
            // Old values: 'in_progress', 'completed'
            // New values: 'in_progress', 'pending', 'approved', 'rejected'
            $table->enum('status', ['in_progress', 'pending', 'approved', 'rejected'])->default('in_progress')->change();
            
            // Add notes column for rejection reason or admin notes
            $table->text('notes')->nullable()->after('evidence');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mission_user', function (Blueprint $table) {
            $table->enum('status', ['in_progress', 'completed'])->default('in_progress')->change();
            $table->dropColumn('notes');
        });
    }
};
