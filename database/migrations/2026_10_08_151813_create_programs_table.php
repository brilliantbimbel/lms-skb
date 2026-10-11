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
    Schema::create('programs', function (Blueprint $table) {
        $table->id();
        $table->string('code')->unique(); // Contoh: paket-a, paket-b, paket-c
        $table->string('name'); // Contoh: Paket A (Setara SD)
        $table->text('description')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};
