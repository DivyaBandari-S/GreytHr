<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
class ManageSwipeRecordsTables extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:manage-swipe-records-tables';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new swipe_records table for each month automatically';

    /**
     * Execute the console command.
     */
    public function handle()
    {
         // Define the table prefix
         $tablePrefix = 'swipe_records_';

         // Get the current month's table name
         $newTable = $tablePrefix . now()->format('m_Y');

         // Check if the table for the current month already exists
         if (!Schema::hasTable($newTable)) {
             // If not, create it using the structure of the original swipe_records table
             DB::statement("CREATE TABLE {$newTable} LIKE swipe_records");
             $this->info("Created new table for the month: {$newTable}");
         } else {
             $this->info("Table {$newTable} already exists.");
         }
    }
}
