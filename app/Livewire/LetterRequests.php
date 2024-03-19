<?php

namespace App\Livewire;

use App\Models\LetterRequest;
use Livewire\Component;

class LetterRequests extends Component
{
    public $allRequests;
    public $activeTab = "Apply";
    public function openForLetters($id)
    {
        $s = LetterRequest::find($id);
        $s->update(['status' => 'Completed']);
        return redirect()->to('/letter-requests');
    }

    public function pendingForLetters($id)
    {
        $s = LetterRequest::find($id);

        $s->update(['status' => 'Pending']);
        return redirect()->to('/letter-requests');
    }
    public function comForLetters($id)
    {
        $s = LetterRequest::find($id);

        $s->update(['status' => 'Completed']);
        return redirect()->to('/letter-requests');
    }

    public function actForLetters($id){
        $s = LetterRequest::find($id);

        $s->update(['status' => 'Active']);
        return redirect()->to('/letter-requests');
    }
    public function render()
    {
        if (auth()->guard('hr')->check()) {
            $companyId = auth()->guard('hr')->user()->company_id;

            $this->allRequests = LetterRequest::with('emp')
            ->whereHas('emp', function ($query) use ($companyId) {
                $query->where('company_id', $companyId);
            })->orderBy('created_at', 'desc')->get();
        }
        return view('livewire.letter-requests');
    }
}
