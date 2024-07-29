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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('emp_id');
            $table->string('task_name')->nullable();
            $table->string('assignee')->nullable();
            $table->string('leave_reason');
            $table->string('leave_status')->default('Pending');
            $table->string('applying_to');
            $table->string('cc_to');
            $table->string('receiver_id')->nullable();
            $table->string('notification_type');
            $table->string('body')->nullable();
            $table->boolean('is_read')->default(false);

            $table->enum('leave_type', ['Casual Leave', 'Sick Leave', 'Loss Of Pay','Maternity Leave','Casual Leave Probation','Marriage Leave','Petarnity Leave', 'Work From Home' ]);


            $table->foreign('emp_id')
            ->references('emp_id')
            ->on('employee_details')
            ->onDelete('restrict')
            ->onUpdate('cascade');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
