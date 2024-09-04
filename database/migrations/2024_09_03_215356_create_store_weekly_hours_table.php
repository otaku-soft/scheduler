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
        Schema::create('store_weekly_hours', function (Blueprint $table) {
            $table->id();
            $table->integer("store_id");
            $table->string("day");
            $table->time("starting_time");
            $table->time("ending_time");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_weekly_hours');
    }
};
