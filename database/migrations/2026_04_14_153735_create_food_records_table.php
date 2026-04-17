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
        Schema::create('food_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('child_id')->constrained('childrens')->cascadeOnDelete();
            $table->date('record_date');
            $table->string('food_type'); // Contoh: Bubur Tim Ayam
            $table->enum('feeding_period', ['Pagi', 'Siang', 'Sore', 'Malam']); // Lebih mudah untuk Admin
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('food_records');
    }
};
