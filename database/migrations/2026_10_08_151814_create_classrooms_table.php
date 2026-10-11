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
    Schema::create('classrooms', function (Blueprint $table) {
        $table->id();
        $table->foreignId('program_id')->constrained()->onDelete('cascade');
        $table->foreignId('tutor_id')->nullable()->constrained('users')->onDelete('set null'); // Wali Kelas / Tutor Pendamping
        $table->string('name'); // Contoh: Tingkat 5 / Kelas 10
        $table->string('academic_year'); // Contoh: 2024/2025
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classrooms');
    }
};
