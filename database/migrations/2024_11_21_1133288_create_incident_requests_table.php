<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('incident_requests', function (Blueprint $table) {
            $table->smallInteger('id')->autoIncrement();
             $table->string('request_id')->nullable()->unique(); // Auto-generated Incident/Service Request ID
            $table->string('emp_id', 10);
            $table->string('category'); // 'Incident Request' or 'Service Request'
            $table->string('short_description')->nullable();
            $table->text('description')->nullable();
            $table->enum('priority', ['low', 'medium', 'high'])->default('low');
            $table->string('assigned_dept')->nullable();
            $table->string('file_path')->nullable();
            $table->string('file_name')->nullable();
            $table->string('mime_type')->nullable();
            $table->tinyInteger('status_code')->default(11); // Default to a "Pending" status
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('emp_id')
                ->references('emp_id')
                ->on('employee_details')
                ->onDelete('restrict');
            $table->foreign('status_code')
                ->references('status_code')
                ->on('status_types')
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });

        // Drop the trigger if it already exists
        DB::unprepared('DROP TRIGGER IF EXISTS generate_request_id');

        // Create the trigger for auto-generating request_id
        $triggerSQL = <<<SQL
        CREATE TRIGGER generate_request_id BEFORE INSERT ON incident_requests FOR EACH ROW
        BEGIN
            IF NEW.request_id IS NULL THEN
                IF NEW.category = 'Incident Request' THEN
                    SET @max_id := IFNULL(
                        (SELECT MAX(CAST(SUBSTRING(request_id, 5) AS UNSIGNED)) 
                         FROM incident_requests WHERE request_id LIKE 'INC-%'),
                        0
                    ) + 1;

                    SET NEW.request_id = CONCAT('INC-', LPAD(@max_id, 4, '0'));
                ELSEIF NEW.category = 'Service Request' THEN
                    SET @max_id := IFNULL(
                        (SELECT MAX(CAST(SUBSTRING(request_id, 4) AS UNSIGNED)) 
                         FROM incident_requests WHERE request_id LIKE 'SR-%'),
                        0
                    ) + 1;

                    SET NEW.request_id = CONCAT('SER-', LPAD(@max_id, 4, '0'));
                END IF;
            END IF;
        END;
        SQL;

        DB::unprepared($triggerSQL);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the trigger
        DB::unprepared('DROP TRIGGER IF EXISTS generate_request_id');

        // Drop the table
        Schema::dropIfExists('incident_requests');
    }
};