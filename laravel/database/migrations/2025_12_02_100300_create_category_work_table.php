<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('category_work', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->foreignId('work_id')->constrained('works')->cascadeOnDelete();
            $table->unique(['category_id', 'work_id']); // 同一組み合わせを重複させない
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('category_work');
    }
};
