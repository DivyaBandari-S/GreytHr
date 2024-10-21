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
        Schema::create('help_desks', function (Blueprint $table) {
            $table->smallInteger('id')->autoIncrement();
            $table->string('emp_id',10);
            $table->string('category',50);
            $table->string('mail',50);
            $table->string('distributor_name',100);
            $table->string('mobile',20);
            $table->text('subject');
            $table->text('description');
            $table->text('active_comment')->nullable();
             $table->text('inprogress_remarks')->nullable();
             $table->string('assign_to')->nullable();
            $table->string('file_path')->nullable(); // Path to attached file (nullable)
            $table->string('cc_to')->nullable(); // CC to field (nullable)
            $table->string('status',20)->default('Recent'); // CC to field (nullable)
            $table->enum('selected_equipment',['keyboard', 'mouse', 'monitor','headset']);
            $table->enum('priority', ['High', 'Medium', 'Low']); // Priority field with enum values
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
        Schema::dropIfExists('help_desks');
    }
};
