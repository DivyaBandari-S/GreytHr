<?php


namespace App\Livewire;
use App\Models\Image;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;


class ImageUpload extends Component
{
    use WithFileUploads;


    public $image;


    public function mount()
    {

    }


    public function uploadImage()
    {
        $this->validate([
            'image' => 'required|image|max:512', // maximum size in kilobytes
        ]);

        $imageData = file_get_contents($this->image->getRealPath());
        $mimeType = $this->image->getMimeType();

        Image::create([
            'image' => $imageData,
            'mime_type' => $mimeType,
        ]);

        session()->flash('message', 'Image has been uploaded successfully');

        $this->image = ''; // Reset the image input
    }

    public function render()
    {
        // Get Uploaded Images
        $images = Image::orderBy('id', 'DESC')->get();

        return view('livewire.image-upload', ['images' => $images]);
    }

}