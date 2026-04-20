<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
        public function up(): void
            {
                // ADD THIS LINE: Drop the old draft of the table first
                Schema::dropIfExists('subjects');

                // 1. Create Subjects Table
                Schema::create('subjects', function (Blueprint $table) {
                    $table->id();
                    $table->string('subject_code')->unique();
                    $table->string('name');
                    $table->integer('units');
                    $table->timestamps();
                });

        // 2. Create Schedules Table
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')->constrained('sections')->onDelete('cascade');
            $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade');
            $table->string('day');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('room');
            $table->timestamps();
        });

        // 3. Add 'course' column to the existing Sections table
        Schema::table('sections', function (Blueprint $table) {
            $table->string('course')->nullable()->after('section_name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedules');
        Schema::dropIfExists('subjects');
        Schema::table('sections', function (Blueprint $table) {
            $table->dropColumn('course');
        });
    }
};