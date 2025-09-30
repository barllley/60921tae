<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exhibition_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('exhibition_id')->constrained()->onDelete('cascade');
            $table->timestamp('visited_at')->nullable();
            $table->timestamps();

            // Уникальная комбинация user_id и exhibition_id
            $table->unique(['user_id', 'exhibition_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exhibition_user');
    }
};
