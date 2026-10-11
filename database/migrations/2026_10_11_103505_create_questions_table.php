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
    Schema::create('questions', function (Blueprint $table) {
        $table->id();
        $table->foreignId('quiz_id')->constrained()->onDelete('cascade');
        $table->text('question_text');
        $table->enum('type', ['multiple_choice', 'essay'])->default('multiple_choice');
        $table->text('option_a')->nullable();
        $table->text('option_b')->nullable();
        $table->text('option_c')->nullable();
        $table->text('option_d')->nullable();
        $table->string('correct_answer')->nullable(); // 'a', 'b', 'c', atau 'd'
        $table->integer('score_weight')->default(10); // Bobot nilai soal
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
