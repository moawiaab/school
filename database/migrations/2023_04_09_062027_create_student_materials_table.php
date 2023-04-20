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
        Schema::create('student_materials', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('material_id')->foreign('material_id')->references('id')->on('materials')->nullable();
            $table->bigInteger('student_id')->foreign('student_id')->references('id')->on('students')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->decimal('degree')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_materials');
    }
};
