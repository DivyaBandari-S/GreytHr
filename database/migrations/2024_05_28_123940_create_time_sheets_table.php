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
        Schema::create('time_sheets', function (Blueprint $table) {
            $table->id();
            $table->string('emp_id');
            $table->string('week_start_date');
            $table->decimal('monday_hours', 8, 2)->nullable();
            $table->decimal('tuesday_hours', 8, 2)->nullable();
            $table->decimal('wednesday_hours', 8, 2)->nullable();
            $table->decimal('thursday_hours', 8, 2)->nullable();
            $table->decimal('friday_hours', 8, 2)->nullable();
            $table->decimal('saturday_hours', 8, 2)->nullable();
            $table->decimal('sunday_hours', 8, 2)->nullable();
            $table->json('client_task_mapping')->nullable();
            $table->timestamps();
            $table->foreign('emp_id')
            ->references('emp_id')
            ->on('employee_details')
            ->onDelete('restrict')
            ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('time_sheets');
    }
};
