<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\SalaryRevision;
class SalaryRevisions extends Component
{
    public $salaryRevisions;
    public $years = [];
    public $salaries = [];
    public $data = [];
    public $chartData;
    public $chartOptions;
    public function render()
    {
        $this->salaryRevisions = SalaryRevision::where('emp_id',auth()->guard('emp')->user()->emp_id)->get();
        $this->salaryRevisions->each(function ($revision) {
            $previousCtc = $revision->previous_monthly_ctc;
            $latestCtc = $revision->revised_monthly_ctc;
            $lastRevisionDate = $revision->last_revision_period;
            $presentRevisionDate = $revision->present_revision_period;
 
 
            if ($previousCtc != 0) {
 
                $revision->percentageChange = (($latestCtc - $previousCtc) / $previousCtc) * 100;
 
            } else {
 
                $revision->percentageChange = 0;
            }
 
            $lastRevisionDate = \Carbon\Carbon::parse($revision->last_revision_period);
            $presentRevisionDate = \Carbon\Carbon::parse($revision->present_revision_period);
 
            if ($lastRevisionDate && $presentRevisionDate) {
                $diff = $lastRevisionDate->diff($presentRevisionDate);
                $duration = [
                    'months' => $diff->y * 12 + $diff->m, // Calculate months
                    'days' => $diff->d, // Calculate days
                ];
                $revision->duration = $duration;
            } else {
                $revision->duration = ['months' => 0, 'days' => 0]; // Handle the case where dates are missing or invalid
            }
 
            $this->years = [];
            $this->salaries = [];
 
            foreach ($this->salaryRevisions as $revision) {
                $lastRevisionDate = \Carbon\Carbon::parse($revision->last_revision_period);
                $presentRevisionDate = \Carbon\Carbon::parse($revision->present_revision_period);
 
                // Calculate the range of years between last and present revision dates
                $yearRange = range($lastRevisionDate->year, $presentRevisionDate->year);
 
                // Add the year range to the years array
                $this->years[] = $yearRange;
 
                // For salaries, you can add the same salary for each year in the range
                $salary = $revision->revised_monthly_ctc;
                $this->salaries[] = array_fill(0, count($yearRange), $salary);
            }
 
            // Flatten the arrays to have a flat list of years and salaries
            $this->years = array_merge(...$this->years);
            $this->salaries = array_merge(...$this->salaries);
          foreach ($this->years as $key => $year) {
                      $data[] = ['year' => $year, 'salary' => $this->salaries[$key]];
                    }
 
                    $this->chartData = [
                        'labels' => array_column($data, 'year'),
                        'datasets' => [
                            [
                                'label' => 'Salary',
                                'data' => array_column($data, 'salary'),
                                'borderColor' => 'blue',
                                'fill' => false,
                            ],
                        ],
                    ];
 
                    $this->chartOptions = [
                        'responsive' => true,
                        'scales' => [
                            'x' => [
                                'display' => true,
                                'title' => [
                                    'display' => true,
                                    'text' => 'Year',
                                ],
                            ],
                            'y' => [
                                'display' => true,
                                'title' => [
                                    'display' => true,
                                    'text' => 'Salary',
                                ],
                            ],
                        ],
                    ];
        });

        return view('livewire.salary-revisions', [
            'salaryRevisions' => $this->salaryRevisions,
            'chartData' =>$this->chartData,
            'chartOptions' =>$this->chartOptions,
        ]);
 
 
    }
}


