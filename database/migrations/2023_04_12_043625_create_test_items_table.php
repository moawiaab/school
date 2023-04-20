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
        Schema::create('test_items', function (Blueprint $table) {
            $table->id();
            $table->string('answer');
            $table->tinyInteger('status')->default(1);
            $table->bigInteger('ask_id')->foreign('ask_id')->references('id')->on('test_models')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_items');
    }
};
