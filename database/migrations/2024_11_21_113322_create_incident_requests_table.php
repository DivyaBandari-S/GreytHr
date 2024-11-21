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
            $table->string('incident_id')->nullable()->unique(); // Auto-generated Incident ID
            $table->string('emp_id',10);
            $table->string('short_description')->nullable();
            $table->text('description')->nullable();
            $table->enum('priority', ['low', 'medium', 'high'])->default('low');
            $table->string('assigned_dept')->nullable();
            $table->string('file_path')->nullable();
            $table->string('file_name')->nullable();
            $table->string('mime_type')->nullable();
            $table->tinyInteger('status_code')->default(11);
            $table->timestamps();
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

        // Create the trigger for auto-generating incident_id
        $triggerSQL = <<<SQL
        CREATE TRIGGER generate_incident_id BEFORE INSERT ON incident_requests FOR EACH ROW
        BEGIN
            IF NEW.incident_id IS NULL THEN
                -- Generate INC-0001 style ID
                SET @max_id := IFNULL(
                    (SELECT MAX(CAST(SUBSTRING(incident_id, 5) AS UNSIGNED)) FROM incident_requests),
                    0
                ) + 1;

                SET NEW.incident_id = CONCAT('INC-', LPAD(@max_id, 4, '0'));
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
        DB::unprepared('DROP TRIGGER IF EXISTS generate_incident_id');

        // Drop the table
        Schema::dropIfExists('incident_requests');
    }
};
