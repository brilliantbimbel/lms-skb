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
    Schema::create('online_meetings', function (Blueprint $table) {
        $table->id();
        $table->foreignId('classroom_id')->constrained()->onDelete('cascade');
        $table->foreignId('subject_id')->constrained()->onDelete('cascade');
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Tutor pembuat
        $table->string('title'); // Contoh: Pertemuan Sabtu - Modul 2
        $table->text('meeting_link'); // Link Google Meet / Zoom
        $table->dateTime('start_time'); // Jam Mulai
        $table->dateTime('end_time'); // Jam Selesai
        $table->text('notes')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('online_meetings');
    }
};
