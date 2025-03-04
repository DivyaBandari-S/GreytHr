<?php

namespace App\Livewire;

use App\Helpers\FlashMessageHelper;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class LocationFinder extends Component
{
    public $latitude;
    public $longitude;
    public $city;
    public $region;
    public $country;

    public function mount()
    {
        // Call the IP Geolocation API
        
    }
    public function render()
    {
        return view('livewire.location-finder');
    }
}
