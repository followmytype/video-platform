<div class="my-2">
    {{-- Close your eyes. Count to one. That is how long forever feels. --}}
    <div class="d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center">
            <img src="{{ asset('images'. '/' . $channel->image) }}" class="rounded-circle" />
            <div class="ml-2">
                <h4>
                    {{ $channel->name }}
                </h4>
                <p class="gray-text text-sm">
                    訂閱數：{{ $channel->subscribers() }}
                </p>
            </div>
        </div>
        <div>
            <button class="btn btn-lg text-uppercase {{ $userSubscribed ? 'sub-btn-active' : 'sub-btn'}}" wire:click.prevent="toggle">
                {{ $userSubscribed ? '已訂閱' : '訂閱' }}
            </button>
        </div>
    </div>
</div>
