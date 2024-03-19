<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\EmployeeDetails;
use App\Models\MonthlyLeaveSummary;

class GenerateMonthlyLeaves extends Command
{
    protected $signature = 'generate:monthly-leaves';
    protected $description = 'Generate and store monthly sick and casual leaves for all employees';
    

    public function handle()
    {
        $currentYear = now()->format('Y');
        $previousYear = now()->subYear()->format('Y');

        // Delete all existing leave records for the previous year
        MonthlyLeaveSummary::whereYear('month', $previousYear)->delete();

        $currentMonth = now()->format('Y-m-d');
        $employeeDetails = EmployeeDetails::all();

        foreach ($employeeDetails as $employee) {
            $employeeId = $employee->emp_id;

            // Check if a summary record already exists for the current month and employee
            $monthlySummary = MonthlyLeaveSummary::where([
                'emp_id' => $employeeId,
                'month' => $currentMonth,
            ])->first();
            if ($monthlySummary) {
                $this->info("Leave summary already updated for {$currentMonth} for employee {$employeeId}.");
                continue;
            }

            // If no summary record exists, create a new one
            $monthlySummary = new MonthlyLeaveSummary([
                'emp_id' => $employeeId,
                'month' => $currentMonth,
            ]);

            // Update the sick leave count
            $monthlySummary->sick_leave_count += 1;

            // Update the casual leave count
            $monthlySummary->casual_leave_count += 1;

            // Save the summary record
            $monthlySummary->save();

            $this->info("Leave summary updated for {$currentMonth} for employee {$employeeId}.");
        }

        $this->info('Monthly leaves generated and stored successfully.');
    }

    }

