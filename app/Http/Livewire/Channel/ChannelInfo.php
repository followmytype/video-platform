<?php

namespace App\Http\Livewire\Channel;

use App\Models\Channel;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ChannelInfo extends Component
{
    public Channel $channel;
    public $userSubscribed = false;

    public function mount(Channel $channel)
    {
        $this->channel = $channel;
        if (auth()->check() && auth()->user()->isSubscribedTo($channel)) {
            $this->userSubscribed = true;
        }
    }

    public function render()
    {
        return view('livewire.channel.channel-info')
            ->extends('layouts.app');
    }

    public function toggle()
    {
        if (!Auth::check()) {
            return redirect('/login');
        }
        $user = auth()->user();
        if ($user->isSubscribedTo($this->channel)) {
            Subscription::where('user_id', $user->id)
                ->where('channel_id', $this->channel->id)
                ->delete();
            $this->userSubscribed = false;
        } else {
            Subscription::create([
                'user_id' => $user->id,
                'channel_id' => $this->channel->id,
            ]);
            $this->userSubscribed = true;
        }
    }
}
