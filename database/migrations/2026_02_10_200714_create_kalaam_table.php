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
        Schema::create('kalaam', function (Blueprint $table) {
            $table->id();

            // Urdu Basic Info
            $table->string('title'); // عنوان
            $table->string('slug')->unique(); // URL

            // Poet (Urdu)
            $table->string('poet_name')->nullable(); // شاعر / نعت خواں

            // Content (Urdu Poetry)
            $table->longText('content'); // مکمل نعت (ہر شعر کے درمیان empty line)

            // Structure Info (clear & meaningful)
            $table->unsignedInteger('lines_per_sheir')->default(2); // ہر شعر میں کتنی لائنز (mostly 2)
            $table->unsignedTinyInteger('sort_no')->default(1);
            // Optional
            $table->string('thumbnail')->nullable();

            // Status
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            // Indexes
            $table->index('title');
            $table->index('poet_name');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kalaam');
    }
};
