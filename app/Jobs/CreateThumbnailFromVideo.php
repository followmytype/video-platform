<?php

namespace App\Jobs;

use App\Models\Video;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class CreateThumbnailFromVideo implements ShouldQueue
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
        // 儲存的位置：/{video-uid}/{video-uid}.png
        $destination = "/" . $this->video->uid . "/" . $this->video->uid . ".png";
        Log::info("即將產生預覽圖片，位置：$destination");

        // 將影片第兩秒的畫面截出來，當作預覽圖片
        FFMpeg::fromDisk('video-temp')
            ->open($this->video->path)
            ->getFrameFromSeconds(2)
            ->export()
            ->toDisk('videos')
            ->save($destination);
        Log::info("預覽圖片完成，更新資料庫紀錄...");

        $this->video->update([
            'thumbnail_image' => $this->video->uid . ".png",
        ]);
    }
}
