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
        Schema::table('doctors', function (Blueprint $table) {
            $table->string('state')->nullable()->after('specialization');
            $table->string('city')->nullable()->after('state');
            $table->time('start_time')->default('09:00:00')->after('availability');
            $table->time('end_time')->default('17:00:00')->after('start_time');
            $table->integer('daily_limit')->default(15)->after('end_time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('doctors', function (Blueprint $table) {
            $table->dropColumn(['state', 'city', 'start_time', 'end_time', 'daily_limit']);
        });
    }
};
