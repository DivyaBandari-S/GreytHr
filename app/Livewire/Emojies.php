<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;
use App\Models\Emoji;
class Emojies extends Component
{
      
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'emoji' => 'required|string|max:255',
        ]);

        Emoji::create([
            'selected_emoji' => $validatedData['emoji'],
            
        ]);
        return response()->json(['message' => 'Emoji stored successfully']);
    }

    public function render()
    {
        return view('livewire.emojies',['employees' => $this->employeeDetails,
        'retrievedData' => $this->retrievedData,
        'selectedEmoji' => $this->selectedEmoji,]);
    }
}
