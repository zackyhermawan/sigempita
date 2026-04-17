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
        Schema::create('growth_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('child_id')->constrained('childrens')->cascadeOnDelete();
            
            // Siapa admin yang memberikan penilaian status gizi
            $table->foreignId('admin_id')->nullable()->constrained('users')->nullOnDelete();

            $table->date('record_date'); // Tanggal pengecekan
            $table->decimal('weight', 5, 2); // Berat Badan
            $table->decimal('height', 5, 2); // Tinggi Badan
            
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('growth_records');
    }
};
