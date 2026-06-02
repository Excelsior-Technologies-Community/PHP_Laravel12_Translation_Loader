<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('translation_histories')) {
            Schema::create('translation_histories', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('language_line_id');
                $table->json('text');
                $table->timestamps();

                $table->foreign('language_line_id')->references('id')->on('language_lines')->onDelete('cascade');
            });
        }

        if (!Schema::hasTable('missing_translations')) {
            Schema::create('missing_translations', function (Blueprint $table) {
                $table->id();
                $table->string('group');
                $table->string('key');
                $table->integer('count')->default(1);
                $table->timestamps();

                $table->unique(['group', 'key']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('translation_histories');
        Schema::dropIfExists('missing_translations');
    }
};