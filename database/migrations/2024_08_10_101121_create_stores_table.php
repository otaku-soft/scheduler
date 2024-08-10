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
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string("name");
            $table->text("address");
            $table->text("address2")->nullable();
            $table->string("city");
            $table->string("state");
            $table->unsignedInteger("zip");
            $table->unsignedInteger("zip2")->nullable();
            $table->string("phone");
            $table->string("email");
            $table->string("slug");
            $table->integer("order");
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};
