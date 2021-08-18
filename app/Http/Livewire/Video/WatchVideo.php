<?php

namespace App\Http\Livewire\Video;

use App\Models\Video;
use Livewire\Component;

class WatchVideo extends Component
{
    // 事件監聽器，可以命名一個事件並且給他對應的行為，讓前端去觸發他
    protected $listeners = ['VideoViewed' => 'addViewCount'];

    public $video;

    public function mount(Video $video)
    {
        $this->video = $video;
    }

    public function render()
    {
        return view('livewire.video.watch-video')
            ->extends('layouts.app');
    }

    public function addViewCount()
    {
        $this->video->update([
            'views' => $this->video->views + 1,
        ]);
    }
}
