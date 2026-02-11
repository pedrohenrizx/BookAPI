<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('book_theme', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->constrained('books')->onDelete('cascade');
            $table->foreignId('theme_id')->constrained('themes')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['book_id', 'theme_id']); // Impede duplicidade
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('book_theme');
    }
};