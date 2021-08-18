<div>
    {{-- Stop trying to control. --}}
    @push('custom-css')
    <link href="https://vjs.zencdn.net/7.14.3/video-js.css" rel="stylesheet" />
    @endpush

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="video-container">
                    <video id="the-video" class="video-js vjs-fill vjs-styles=defaults vjs-big-play-centered" controls preload="auto" poster="{{ asset($video->thumbnail) }}" data-setup="{}" wire:ignore>
                        <source src="{{ asset('videos/' . $video->uid . '/' . $video->processed_file) }}" type="application/x-mpegURL" />
                        <p class="vjs-no-js">
                            To view this video please enable JavaScript, and consider upgrading to a
                            web browser that
                            <a href="https://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
                        </p>
                    </video>
                </div>
                <h2>{{ $views }}</h2>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://vjs.zencdn.net/7.14.3/video.min.js"></script>
    <script>
        var player = videojs('the-video');
        player.ready(function() {
            // console.log('影片準備好');
            player.play();
        });

        player.on('timeupdate', function() {
            // 當播放時間變更時
            // console.log(this.currentTime()); // 時間
            if (this.currentTime() > 3) {
                this.off('timeupdate'); // 停止監聽播放時間

                Livewire.emit('VideoViewed'); // 觸發在後端建立的事件
            }
        });

        player.on('ended', function() {
            console.log('影片結束');
        });
    </script>
    @endpush
</div>