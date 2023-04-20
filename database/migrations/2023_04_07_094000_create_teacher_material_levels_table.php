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
        Schema::create('teacher_material_levels', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('teacher_id')->foreign('teacher_id')->references('id')->on('teachers')->nullable();
            $table->bigInteger('material_id')->foreign('material_id')->references('id')->on('materials')->nullable();
            $table->bigInteger('level_id')->foreign('level_id')->references('id')->on('levels')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_material_levels');
    }
};
