<?php

namespace App\Http\Livewire\Video;

use App\Models\Video;
use Livewire\Component;

class Voting extends Component
{
    public $video;

    public function mount(Video $video)
    {
        $this->video = $video;
    }

    public function render()
    {
        return view('livewire.video.voting')
            ->extends('layouts.app');
    }
}
