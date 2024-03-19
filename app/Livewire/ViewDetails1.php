<?php

namespace App\Livewire;

use App\Models\View;
use Livewire\Component;

class ViewDetails1 extends Component
{
    public $view_date;
    public $view_time;
    public $views1 = [];
    public function render()
    {
        $views1= View::all();
        return view('livewire.view-details1',['views2'=>$views1]);
    }
}
