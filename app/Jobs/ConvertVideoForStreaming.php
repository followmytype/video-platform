<?php

namespace App\Jobs;

use FFMpeg\Format\Video\X264;
use App\Models\Video;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class ConvertVideoForStreaming implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $video;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Video $video)
    {
        $this->video = $video;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // 儲存的位置：/{video-uid}/{video-uid}.m3u8
        $destination = "/" . $this->video->uid . "/" . $this->video->uid . ".m3u8";
        Log::info("即將產生串流檔，位置：$destination");

        // 產生低畫質跟高畫質兩個規格
        $low = (new X264('aac'))->setKiloBitrate(500);
        $high = (new X264('aac'))->setKiloBitrate(1000);

        $media = FFMpeg::fromDisk('video-temp')
            ->open($this->video->path)
            ->exportForHLS()
            ->addFormat($low, function ($filters) {
                $filters->resize(640, 480);
            })
            ->addFormat($high, function ($filters) {
                $filters->resize(1280, 720);
            })
            ->onProgress(function($progress) {
                $this->video->update([
                    'processing_percentage' => $progress,
                ]);
            })
            ->toDisk('videos')
            ->save($destination);
        Log::info("串流檔案完成，更新資料庫紀錄...");
        $duration = gmdate('H:i:s', $media->getDurationInSeconds());

        $this->video->update([
            'processed' => true,
            'processed_file' => $this->video->uid . '.m3u8',
            'duration' => $duration,
        ]);

        // 刪除暫存檔案
        Storage::disk('video-temp')->delete($this->video->path);
        Log::info("已刪除 {$this->video->path} 影片暫存檔");
    }
}
