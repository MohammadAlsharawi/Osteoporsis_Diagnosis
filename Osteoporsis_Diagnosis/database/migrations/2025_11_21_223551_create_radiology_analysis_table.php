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
        Schema::create('radiology_analysis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->foreignId('doctor_id')->constrained('users')->onDelete('cascade');
            $table->string('original_image_path');
            $table->string('ai_processed_image_path')->nullable();
            $table->string('site')->nullable();
            $table->float('t_score_value')->nullable();
            $table->float('z_score_value')->nullable();
            $table->string('diagnosis')->nullable();
            $table->enum('status', ['pending','processed','failed'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('radiology_analysis');
    }
};
