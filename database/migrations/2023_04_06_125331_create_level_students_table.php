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
        Schema::create('level_students', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('student_id')->foreign('student_id')->references('id')->on('students')->nullable();
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
        Schema::dropIfExists('level_students');
    }
};
