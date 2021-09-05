<?php

namespace App\Http\Livewire\Comment;

use App\Models\Video;
use Livewire\Component;

class NewComment extends Component
{
    public Video $video;
    public $body;
    public $replyOn;

    public function mount(Video $video, $replyOn)
    {
        $this->video = $video;
        $this->replyOn = $replyOn == 0 ? null : $replyOn;
    }

    public function render()
    {
        return view('livewire.comment.new-comment')
            ->extends('layouts.app');
    }

    public function resetForm()
    {
        $this->body = "";
    }

    public function addComment()
    {
        auth()->user()->comments()->create([
            'body' => $this->body,
            'video_id' => $this->video->id,
            'reply_id' => $this->replyOn,
        ]);

        $this->body = "";
        $this->emit('commentCreated');
    }
}
