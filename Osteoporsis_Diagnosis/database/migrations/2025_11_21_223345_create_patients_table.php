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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained('users')->onDelete('cascade');
            $table->string('first_name');
            $table->string('father_name')->nullable();
            $table->string('last_name');
            $table->enum('gender', ['male','female'])->nullable();
            $table->integer('age')->nullable();
            $table->integer('menopause_age')->nullable();
            $table->float('height_m')->nullable();
            $table->float('weight_kg')->nullable();
            $table->float('bmi')->nullable();
            $table->string('occupation')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
