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
    Schema::create('attendances', function (Blueprint $table) {
        $table->id();
        $table->foreignId('online_meeting_id')->constrained()->onDelete('cascade');
        $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
        $table->enum('status', ['hadir', 'izin', 'sakit', 'alpha'])->default('hadir');
        $table->text('notes')->nullable();
        $table->timestamps();

        $table->unique(['online_meeting_id', 'student_id']); // 1 siswa hanya 1 status per pertemuan
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
