<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscription_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('studio_id')->constrained()->onDelete('cascade');
            $table->string('name'); // Месячный, 4 занятия, 8 занятий, Разовое, Персональное
            $table->decimal('price', 10, 2);
            $table->integer('lessons_count')->nullable(); // Количество занятий (null для месячных)
            $table->integer('validity_days')->nullable(); // Срок действия в днях
            $table->boolean('is_one_time')->default(false); // Разовое занятие
            $table->boolean('is_personal')->default(false); // Персональное занятие
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscription_types');
    }
};
