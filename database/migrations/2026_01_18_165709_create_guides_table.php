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
        Schema::create('guides', function (Blueprint $table) {
            $table->id();
            
            // --- KONTEN EDUKASI ---
            $table->string('title');        // Judul Artikel
            $table->string('category');     // Kategori (misal: "Organik", "3R", "Bahaya Plastik")
            $table->longText('content');    // Isi artikel (bisa panjang sekali)
            // ----------------------

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guides');
    }
};