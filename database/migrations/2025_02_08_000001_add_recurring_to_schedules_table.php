<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->string('title')->nullable()->after('studio_id');
            $table->json('days_of_week')->nullable()->after('day_of_week'); // [2, 4] = среда, пятница
            $table->boolean('is_enabled')->default(true)->after('is_reserve');
        });
    }

    public function down(): void
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->dropColumn(['title', 'days_of_week', 'is_enabled']);
        });
    }
};
