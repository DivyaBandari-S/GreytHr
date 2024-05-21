<?php
 
namespace App\Livewire;
 
use Livewire\Component;
 
class Investment extends Component
{
    public $showDetails = true;
    public function toggleDetails()
    {
        $this->showDetails = !$this->showDetails;
    }
    public function render()
    {
        return view('livewire.investment');
    }
}