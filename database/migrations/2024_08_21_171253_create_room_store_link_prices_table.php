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
        Schema::create('room_store_link_prices', function (Blueprint $table) {
            $table->id();
            $table->integer("storeLinkId");
            $table->text("type");
            $table->integer("person_number");
            $table->float("price")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_store_link_prices');
    }
};
