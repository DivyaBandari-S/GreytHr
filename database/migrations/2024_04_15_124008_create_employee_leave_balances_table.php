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
        Schema::create('employee_leave_balances', function (Blueprint $table) {
            $table->id();
            $table->string('emp_id');
        $table->enum('leave_type', ['Casual Leave Probation', 'Maternity Leave', 'Loss Of Pay', 'Sick Leave', 'Marriage Leave', 'Casual Leave','Petarnity Leave','Work From Home'])->nullable();
            $table->unsignedInteger('leave_balance')->default(0);
            $table->string('status')->default('Granted');
            $table->date('to_date');
            $table->date('from_date');
            $table->timestamps();
            $table->foreign('emp_id')
            ->references('emp_id')
            ->on('employee_details')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->unique(['emp_id', 'leave_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_leave_balances');
    }
};
