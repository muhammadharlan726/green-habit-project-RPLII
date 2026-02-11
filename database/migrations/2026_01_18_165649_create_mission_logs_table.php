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
        Schema::create('mission_logs', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke User & Mission (Jika user/misi dihapus, log ikut hilang/cascade)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('mission_id')->constrained()->onDelete('cascade');
            
            $table->date('completed_at'); // Tanggal pengerjaan (YYYY-MM-DD)
            $table->integer('points_earned'); // Menyimpan sejarah poin yg didapat
            $table->timestamps();

            // KUNCI PENTING: Mencegah user mengerjakan misi yg sama 2x di hari yg sama
            $table->unique(['user_id', 'mission_id', 'completed_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mission_logs');
    }
};