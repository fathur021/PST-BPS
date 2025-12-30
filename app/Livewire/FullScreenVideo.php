<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Slideshow;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FullScreenVideo extends Component
{
    public $videoPath;

    public function mount()
    {
        $firstVideo = Slideshow::first();
        Log::info($firstVideo);

        if ($firstVideo) {
            $this->videoPath = Storage::url($firstVideo->slideshow_path);
        } else {
            $this->videoPath = null;
        }
    }

    public function render()
    {
        return view('livewire.full-screen-video');
    }
}
