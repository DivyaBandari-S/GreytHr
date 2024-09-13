<?php

namespace App\Livewire;

use Livewire\Component;

class DocForms extends Component
{
    public $showPopup=false;
    public $text='';
    public function render()
    {
        return view('livewire.doc-forms');
    }
    public function downloadPdf(){
    $this->showPopup=true;
    // $this->text=$text;
    // dd($text);
    }
    public function cancel(){
        $this->showPopup=false;
        }
}
