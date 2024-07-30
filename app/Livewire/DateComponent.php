<?php

namespace App\Livewire;

use Livewire\Component;

class DateComponent extends Component
{
    public string $start = '';
    public string $end = '';

    public function mount($start, $end)
    {
        $this->start = $start;
        $this->end = $end;
    }
       public function updatedStart($value)
    {
        $this->emitUp('updateStart', $value);
    }

    public function updatedEnd($value)
    {
        $this->emitUp('updateEnd', $value);
    }

    public function render()
    {
        return view('livewire.date-component');
    }
}
