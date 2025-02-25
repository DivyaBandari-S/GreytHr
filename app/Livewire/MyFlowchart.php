<?php

namespace App\Livewire;

use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Asantibanez\LivewireCharts\Models\PieChartModel;
use Livewire\Component;

class MyFlowchart extends Component
{
    public $absent;
    public $present;
    public $leaveTaken;

    public $holidays;
    public function render()
    {
        $pieChartModel = (new PieChartModel())
            ->asDonut() // Set the chart as a doughnut chart
            ->addSlice('Absent', $this->absent, 'rgb(184, 208, 221)')
            ->addSlice('Present', $this->present, 'rgb(192, 238, 249)')
            ->addSlice('Leave Taken', $this->leaveTaken, color: 'rgb(255, 221, 189)')
            ->addSlice('Holiday', $this->holidays, 'rgb(183, 227, 192)')
            ->setJsonConfig([
                     'chart' => [
            'width' => 600, // Set the width of the chart
            'height' => 400, // Set the height of the chart
        ],
         
       
        ]);
    
        return view('livewire.my-flowchart', [
            'pieChartModel' => $pieChartModel,
        ]);
    }
}
