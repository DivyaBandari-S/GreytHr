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
        Schema::create('emp_salaries', function (Blueprint $table) {
            $table->smallInteger('id')->autoIncrement();
            $table->smallInteger('sal_id');
            $table->string('salary'); // Use string for encrypted salary
            $table->date('month_of_sal');
            $table->date('effective_date');
            $table->string('remarks')->nullable();
            $table->timestamps();
            $table->foreign('sal_id')->references('id')->on('salary_revisions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emp_salaries');
    }
};
