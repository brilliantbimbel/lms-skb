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
    Schema::create('assignments', function (Blueprint $table) {
        $table->id();
        $table->foreignId('subject_id')->constrained()->onDelete('cascade');
        $table->foreignId('classroom_id')->constrained()->onDelete('cascade');
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Tutor pembuat
        $table->string('title');
        $table->text('description');
        $table->dateTime('due_date'); // Tenggat waktu pengumpulan
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignments');
    }
};
