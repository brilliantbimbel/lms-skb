<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('materials', function (Blueprint $table) {
            $table->string('video_url')->nullable()->after('file_path');
        });

        Schema::table('assignments', function (Blueprint $table) {
            $table->string('file_path')->nullable()->after('description');
        });
    }

    public function down(): void
    {
        Schema::table('materials', function (Blueprint $table) {
            $table->dropColumn('video_url');
        });

        Schema::table('assignments', function (Blueprint $table) {
            $table->dropColumn('file_path');
        });
    }
};
