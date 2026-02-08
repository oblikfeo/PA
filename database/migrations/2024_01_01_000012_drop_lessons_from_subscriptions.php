<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('subscription_types', function (Blueprint $table) {
            $table->dropColumn('lessons_count');
        });
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropColumn('lessons_remaining');
        });
    }

    public function down(): void
    {
        Schema::table('subscription_types', function (Blueprint $table) {
            $table->integer('lessons_count')->nullable()->after('price');
        });
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->integer('lessons_remaining')->default(0)->after('expires_at');
        });
    }
};
