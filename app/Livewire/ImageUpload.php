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


    public function updated($fields)
    {
        $this->validateOnly($fields,[
            'image' => 'required',
        ]);
    }

    public function uploadImage()
    {
        $this->validate([
            'image' => 'required',
        ]);


        $image = new Image();


        $imageName = Carbon::now()->timestamp. '.' .$this->image->extension();
        $this->image->storeAs('image_uploads', $imageName);

        $image->image = $imageName;


        $image->save();


        session()->flash('message', 'Image has been uploaded successfully');


        $this->image = '';


    }



    public function render()
    {
        //Get Uploaded Images


        $images = Image::orderBy('id','DESC')->get();


        return view('livewire.image-upload',['images'=>$images]);
    }
}
