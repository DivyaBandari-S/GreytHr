<?php

namespace App\Livewire;

use Livewire\Component;

class FeedBack extends Component
{
    public $activeTab = 'recieved';
    public $searchEmployee = '';
    public $message = '';

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function submitFeedback()
    {
        // Validate input
        $this->validate([
            'searchEmployee' => 'required',
            'message' => 'required',
        ]);

        // Process feedback submission (e.g., save to database)
        // Feedback::create(['employee' => $this->searchEmployee, 'message' => $this->message]);

        // Reset fields and close modal
        $this->reset(['searchEmployee', 'message']);
        $this->dispatchBrowserEvent('close-modal', ['modalId' => 'requestFeedbackModal']);
        session()->flash('success', 'Feedback submitted successfully!');
    }

    public function render()
    {
        return view('livewire.feed-back');
    }
}
