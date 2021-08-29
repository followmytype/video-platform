<?php

namespace App\Http\Livewire\Video;

use App\Models\Channel;
use App\Models\Video;
use Livewire\Component;

class EditVideo extends Component
{
    public Channel $channel;
    public Video $video;

    protected $rules = [
        'video.title' => 'required|max:255',
        'video.description' => 'nullable|max:1000',
        'video.visibility' => 'nullable|in:private,public,unlisted',

    ];

    public function mount(Channel $channel, Video $video)
    {
        $this->channel = $channel;
        $this->video = $video;
    }

    public function render()
    {
        return view('livewire.video.edit-video')
            ->extends('layouts.app');
    }

    public function update()
    {
        $this->validate();

        $this->video->update([
            'title' => $this->video->title,
            'description' => $this->video->description,
            'visibility' => $this->video->visibility,
        ]);

        session()->flash('message', '影片編輯成功');

        // return redirect()->route('channel.edit', ['channel' => $this->channel]);
    }
}
