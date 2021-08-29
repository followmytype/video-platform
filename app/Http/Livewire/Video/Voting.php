<?php

namespace App\Http\Livewire\Video;

use App\Models\Video;
use Livewire\Component;

class Voting extends Component
{
    public Video $video;
    // 點讚數
    public $likes;
    // 倒讚數
    public $dislikes;
    // 使用者是否點過讚
    public $likeActive;
    // 使用者是否倒過讚
    public $dislikeActive;

    protected $listeners = ['load_values' => '$refresh'];

    public function mount(Video $video)
    {
        $this->video = $video;
        $this->likeActive = $this->video->doesUserLikedVideo();
        $this->dislikeActive = $this->video->doesUserDislikedVideo();
    }

    public function render()
    {
        // 讚跟倒讚的數量是取自於likes跟dislikes這兩張table
        // 因為他們都沒有綁定在這個livewire裡面，所以他們的增刪都不會做即時的更新
        // 所以將它們放在render做宣告，就能在每次資料有異動時拿到最新的狀態
        $this->likes = $this->video->likes()->count();
        $this->dislikes = $this->video->dislikes()->count();

        return view('livewire.video.voting')
            ->extends('layouts.app');
    }

    // 點讚功能
    public function like()
    {
        // 檢查這個使用者是不是已經點讚過，是的話就取消點讚，反之點讚
        if ($this->likeActive) {
            $this->disableLike();
        } else {
            $this->video->likes()->create([
                'user_id' => auth()->id(),
            ]);
            $this->likeActive = true;

            // 取消使用者倒讚紀錄，背後的行為是刪除使用者倒讚的紀錄，縱使使用者沒有倒過讚，也只是沒有紀錄讓他刪除
            $this->disableDislike();
        }

        $this->emit('load_values');
    }

    // 倒讚功能
    public function dislike()
    {
        if ($this->dislikeActive) {
            $this->disableDislike();
        } else {
            $this->video->dislikes()->create([
                'user_id' => auth()->id(),
            ]);
            $this->dislikeActive = true;
            $this->disableLike();
        }

        $this->emit('load_values');
    }

    // 取消使用者的點讚
    private function disableLike()
    {
        $this->video->likes()->where('user_id', auth()->id())->delete();
        $this->likeActive = false;
    }

    // 取消使用者的倒讚
    private function disableDislike()
    {
        $this->video->dislikes()->where('user_id', auth()->id())->delete();
        $this->dislikeActive = false;
    }
}
