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
    Schema::create('subjects', function (Blueprint $table) {
        $table->id();
        $table->string('code')->unique(); // Contoh: MAT-A, IND-B
        $table->string('name'); // Contoh: Matematika, Bahasa Indonesia
        $table->foreignId('program_id')->nullable()->constrained()->onDelete('cascade'); // Jika null = Berlaku untuk Semua Paket
        $table->foreignId('tutor_id')->nullable()->constrained('users')->onDelete('set null'); // Tutor Pengampu
        $table->text('description')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
