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
        Schema::create('employee_assets', function (Blueprint $table) {

            $table->id();
            $table->string('emp_id')->unique();
            $table->string('asset_tag')->nullable();
            $table->string('status')->nullable();
            $table->string('manufacturer')->nullable();
            $table->string('asset_type')->nullable();
            $table->string('asset_model')->nullable();
            $table->text('asset_specification')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('color')->nullable();
            $table->string('current_owner')->nullable();
            $table->string('previous_owner')->nullable();
            $table->string('windows_version')->nullable();
            $table->date('assign_date')->nullable();
            $table->date('purchase_date')->nullable();
            $table->string('invoice_no')->nullable();
            $table->decimal('taxable_amount', 8, 2)->nullable();
            $table->decimal('gst_central', 8, 2)->nullable();
            $table->decimal('gst_state', 8, 2)->nullable();
            $table->decimal('invoice_amount', 8, 2)->nullable();
            $table->string('vendor')->nullable();
            $table->text('other_assets')->nullable();
            $table->enum('sophos_antivirus', ['Yes', 'No'])->default('No');
            $table->enum('vpn_creation', ['Yes', 'No'])->default('No');
            $table->enum('teramind', ['Yes', 'No'])->default('No');
            $table->string('system_name')->nullable();
            $table->enum('system_upgradation', ['Yes', 'No'])->default('No');
            $table->text('screenshot_of_programms')->nullable();
            $table->enum('one_drive', ['Yes', 'No'])->default('No');
            $table->string('mac_address')->nullable();
            $table->enum('laptop_received', ['Yes', 'No'])->default('No');
            $table->timestamps();
            $table->foreign('emp_id')->references('emp_id')->on('employee_details')->onDelete('cascade');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_assets');
    }
};
