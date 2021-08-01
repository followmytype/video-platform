<div>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @foreach($videos as $video)
                    <div class="card my-2">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <img src="{{ asset($video->thumbnail) }}" class="img-thumbnail">
                                </div>
                                <div class="col-md-3">
                                    <h5>{{ $video->title }}</h5>
                                    <p class="text-truncate">{{ $video->description }}</p>
                                </div>
                                <div class="col-md-2">
                                    {{ $video->visibility }}
                                </div>
                                <div class="col-md-2">
                                    {{ $video->created_at->format('Y/m/d') }}
                                </div>
                                <div class="col-md-2">
                                    <a href="{{ route('video.edit', ['channel' => $video->channel, 'video' => $video]) }}" class="btn btn-light btn-sum">
                                        編輯
                                    </a>
                                    <a class="btn btn-danger btn-sum">
                                        刪除
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            {{ $videos->links() }}
        </div>
    </div>

</div>
