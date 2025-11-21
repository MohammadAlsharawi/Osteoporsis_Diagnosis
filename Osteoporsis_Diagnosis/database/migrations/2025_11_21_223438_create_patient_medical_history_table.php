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
        Schema::create('patient_medical_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->boolean('joint_pain')->default(false);
            $table->boolean('smoker')->default(false);
            $table->boolean('alcoholic')->default(false);
            $table->boolean('diabetic')->default(false);
            $table->boolean('hypothyroidism')->default(false);
            $table->boolean('seizure_disorder')->default(false);
            $table->boolean('estrogen_use')->default(false);
            $table->boolean('history_of_fracture')->default(false);
            $table->boolean('dialysis')->default(false);
            $table->boolean('family_history_osteoporosis')->default(false);
            $table->integer('number_of_pregnancies')->nullable();
            $table->string('maximum_walking_distance')->nullable();
            $table->text('daily_eating_habits')->nullable();
            $table->boolean('obesity')->default(false);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_medical_history');
    }
};
