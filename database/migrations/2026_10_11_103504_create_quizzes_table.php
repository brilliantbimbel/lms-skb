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
    Schema::create('quizzes', function (Blueprint $table) {
        $table->id();
        $table->foreignId('classroom_id')->constrained()->onDelete('cascade');
        $table->foreignId('subject_id')->constrained()->onDelete('cascade');
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Tutor pembuat
        $table->string('title');
        $table->text('description')->nullable();
        $table->integer('duration_minutes')->default(60); // Durasi pengerjaan (menit)
        $table->dateTime('start_time');
        $table->dateTime('end_time');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quizzes');
    }
};
