@foreach ($comments as $comment)
<div class="media my-3" x-data="{open: false, openReply: false}">
    <img class="mr-3 rounded-circle" src="{{ asset('/images/' . $comment->user->channel->image) }}">
    <div class="media-body">
        <h5 class="mt-0">
            {{ $comment->user->name }}
            <small class="text-muted">
                {{ $comment->created_at->diffForHumans() }}
            </small>
        </h5>
        {{ $comment->body }}

        <p class="mt-3">
            <a href="" class="text-muted" @click.prevent="openReply = !openReply">回覆</a>
        </p>
        @auth
        <div class="my-2" x-show="openReply">
            <livewire:comment.new-comment :video="$video" :replyOn="$comment->id" :key="$comment->id . uniqid()" />
        </div>
        @endauth

        @if ($comment->replies()->count())
        <a href="" @click.prevent="open = !open">{{ $comment->replies->count() }} 則回覆</a>
        <div x-show="open">
            @include('includes.recursive', ['comments' => $comment->replies])
        </div>
        @endif
    </div>
</div>
@endforeach
