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
        Schema::create('rewards', function (Blueprint $table) {
            $table->id();
            
            // --- DATA BARANG MARKETPLACE ---
            $table->string('name');             // Nama barang (misal: "Voucher Listrik")
            $table->text('description')->nullable(); // Deskripsi (opsional)
            $table->integer('cost');            // Harga Poin (misal: 500)
            $table->integer('stock')->default(0); // Stok barang yang tersedia
            $table->string('icon')->default('fa-gift'); // Ikon tampilan
            $table->boolean('is_active')->default(true); // Agar admin bisa sembunyikan barang
            // -------------------------------

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rewards');
    }
};