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
        Schema::create('monitorings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('child_id')->constrained('childrens')->cascadeOnDelete();

            // Ambil referensi data pertumbuhan terakhir
            $table->foreignId('growth_record_id')->nullable()->constrained('growth_records')->nullOnDelete();

            // Admin yang menilai
            $table->foreignId('admin_id')->nullable()->constrained('users')->nullOnDelete();

            // Status monitoring
            $table->enum('status', ['pending', 'reviewed', 'warning'])->default('pending');

            // Hasil penilaian
            $table->string('nutritional_status')->nullable();
            $table->text('admin_notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monitorings');
    }
};
