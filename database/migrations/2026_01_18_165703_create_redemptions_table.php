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
        Schema::create('redemptions', function (Blueprint $table) {
            $table->id();
            
            // Relasi: Siapa yang menukar? Barang apa yang diambil?
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('reward_id')->constrained()->onDelete('cascade');
            
            // Status Transaksi (Admin harus menyetujui dulu)
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            
            // Catatan Admin (misal: "Stok habis, poin dikembalikan")
            $table->text('admin_note')->nullable(); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('redemptions');
    }
};