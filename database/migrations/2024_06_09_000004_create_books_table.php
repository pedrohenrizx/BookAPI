<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('synopsis')->nullable();
            $table->string('isbn')->unique();
            $table->year('year')->nullable();
            $table->string('language')->nullable();
            $table->integer('pages')->nullable();
            $table->string('cover_url')->nullable();
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->float('average_rating')->default(0);
            $table->foreignId('publisher_id')->constrained('publishers')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};