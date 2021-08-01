<?php

namespace App\Http\Livewire\Video;

use App\Jobs\ConvertVideoForStreaming;
use App\Jobs\CreateThumbnailFromVideo;
use App\Models\Channel;
use App\Models\Video;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateVideo extends Component
{
    use WithFileUploads;

    public Channel $channel;
    public Video $video;
    public $videoFile;

    protected $rules = [
        'videoFile' => 'required|mimes:mp4|max:1228800',
    ];

    public function mount(Channel $channel)
    {
        $this->channel = $channel;
    }

    public function render()
    {
        return view('livewire.video.create-video')
            ->extends('layouts.app');
    }

    public function fileCompleted()
    {
        // 驗證
        $this->validate();

        // 儲存檔案到暫存
        $path = $this->videoFile->store('video-temp');
        $pathArray = explode('/', $path);

        // 新增影片的資料庫紀錄
        $this->video = $this->channel->videos()->create([
            'uid' => uniqid(true),
            'title' => 'untitled',
            'description' => 'none',
            'visibility' => 'private',
            'path' => end($pathArray),
        ]);

        // 觸發job，執行產生預覽圖，產生串流檔案
        CreateThumbnailFromVideo::dispatch($this->video);
        ConvertVideoForStreaming::dispatch($this->video);

        // 返回影片內容編輯頁
        return redirect()->route('video.edit', [
            'channel' => $this->channel,
            'video' => $this->video,
        ]);
    }
}
