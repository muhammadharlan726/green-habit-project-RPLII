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
        Schema::create('missions', function (Blueprint $table) {
            $table->id();
            
            // --- KOLOM DATA MISI ---
            $table->string('title');            // Judul Misi (misal: "Bawa Tumbler")
            $table->text('description');        // Penjelasan cara mengerjakan
            $table->string('icon')->default('fa-star'); // Ikon tampilan (FontAwesome)
            $table->integer('points_reward')->default(10); // Hadiah poin jika selesai
            $table->enum('frequency', ['daily', 'weekly'])->default('daily'); // Frekuensi
            $table->boolean('is_active')->default(true); // Status aktif/tidak
            // -----------------------

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('missions');
    }
};