<?php
// File Name                       : EmpLogin.php
// Description                     : This file contains the implementation employee salary revision
// Creator                         : Saragada Siva Kumar
// Email                           :
// Organization                    : PayG.
// Date                            : 2024-03-07
// Framework                       : Laravel (10.10 Version)
// Programming Language            : PHP (8.1 Version)
// Database                        : MySQL
// Models                          : EmployeeDetails,Hr,Finance,Admin,IT
namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\SalaryRevision;
use Illuminate\Validation\ValidationException;

class SalaryRevisions extends Component
{
    public $salaryRevisions;
    public $years = [];
    public $salaries = [];
    public $data = [];
    public $chartData;
    public $chartOptions;
    public $error = '';
    public function render()
    {
        try {
            $this->salaryRevisions = SalaryRevision::where('emp_id', auth()->guard('emp')->user()->emp_id)->get();
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
                $labels = [];
                $revisedSalaries = [];
                $previousSalaries = [];

                foreach ($this->salaryRevisions as $revision) {
                    $lastRevisionDate = \Carbon\Carbon::parse($revision->last_revision_period);
                    $presentRevisionDate = \Carbon\Carbon::parse($revision->present_revision_period);

                    // Format dates as "Day Month Year"
                    $lastFormattedDate = $lastRevisionDate->format('j F Y');
                    $presentFormattedDate = $presentRevisionDate->format('j F Y');

                    // Add labels
                    $labels[] = $lastFormattedDate;
                    $labels[] = $presentFormattedDate;

                    // // Add salaries
                    // $revisedSalaries[] = $revision->revised_monthly_ctc;
                    // $previousSalaries[] = $revision->previous_monthly_ctc;
                    // Add salaries
                    $salaries[] = $revision->previous_monthly_ctc; // Add previous salary
                    $salaries[] = $revision->revised_monthly_ctc; // Add revised salary
                }

                $this->chartData = [
                    'labels' => $labels,
                    'datasets' => [
                        [
                            'label' => 'Salary',
                            'data' => $salaries,
                            'borderColor' => 'rgba(54, 162, 235, 1)', // Blue color
                            'fill' => false,
                        ],
                    ],
                ];

                $this->chartOptions = [
                    'responsive' => true,
                    'scales' => [
                        'xAxes' => [
                            [
                                'ticks' => [
                                    'beginAtZero' => true
                                ],
                                'scaleLabel' => [
                                    'display' => true,
                                    'labelString' => 'Date (Day Month Year)'
                                ]
                            ]
                        ],
                        'yAxes' => [
                            [
                                'ticks' => [
                                    'beginAtZero' => true
                                ],
                                'scaleLabel' => [
                                    'display' => true,
                                    'labelString' => 'Salary'
                                ]
                            ]
                        ]
                    ]
                ];
            });

            return view('livewire.salary-revisions', [
                'salaryRevisions' => $this->salaryRevisions,
                'chartData' => $this->chartData,
                'chartOptions' => $this->chartOptions,
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            // Handle database errors
            return view('errors.connection-refused', ['errorMessage' => 'Database error occurred. Please try again later.']);
        } catch (\Exception $e) {
            // Handle general errors
            return view('errors.connection-refused', ['errorMessage' => 'An unexpected error occurred. Please try again.']);
        }
    }
}
