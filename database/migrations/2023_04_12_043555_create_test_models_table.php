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
        Schema::create('test_models', function (Blueprint $table) {
            $table->id();
            $table->string('ask');
            $table->text('details')->nullable();
            $table->tinyInteger('type')->default(1);
            $table->bigInteger('user_id')->foreign('user_id')->references('id')->on('users')->nullable();
            $table->bigInteger('material_id')->foreign('material_id')->references('id')->on('teacher_material_levels')->nullable();
            $table->bigInteger('tutorial_id')->foreign('tutorial_id')->references('id')->on('tutorials')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_models');
    }
};
