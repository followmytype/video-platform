<?php

namespace App\Http\Livewire\Video;

use App\Models\Video;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class AllVideo extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        return view('livewire.video.all-video')
            ->with('videos', Auth::user()->channel->videos()->paginate(10))
            ->extends('layouts.app');
    }
}
