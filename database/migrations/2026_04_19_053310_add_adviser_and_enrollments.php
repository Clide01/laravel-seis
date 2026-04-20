<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Add adviser to sections
        Schema::table('sections', function (Blueprint $table) {
            $table->unsignedBigInteger('adviser_id')->nullable()->after('max_capacity');
        });

        // 2. Create the enrollments table to link students to sections
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // The Student
            $table->foreignId('section_id')->constrained('sections')->onDelete('cascade');
            $table->string('school_year')->default('2026-2027');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enrollments');
        Schema::table('sections', function (Blueprint $table) {
            $table->dropColumn('adviser_id');
        });
    }
};