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
        Schema::create('generate_letters', function (Blueprint $table) {
            $table->id();
            $table->string('template_name'); // Letter Template
            $table->string('serial_no')->unique(); // Auto-generated Serial Number
            $table->json('authorized_signatory')->nullable();
            $table->string('employee_name'); // Employee Full Name
            $table->string('employee_id'); // Employee ID
            $table->text('employee_address'); // Employee Address
            $table->date('joining_date'); // Joining Date
            $table->date('confirmation_date')->nullable(); // Confirmation Date (if applicable)
            $table->longText('letter_content'); // Generated Letter Content
            $table->text('remarks')->nullable();
            $table->decimal('ctc', 10, 2)->nullable();
            $table->string('status')->default('Not Published'); // Letter Status (Default: Not Published)
            $table->timestamps();
        });
    }
    protected $casts = [
        'authorized_signatory' => 'array', // Cast as an array
    ];

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('generate_letters');
    }
};
