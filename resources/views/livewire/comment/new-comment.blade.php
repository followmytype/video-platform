<div>
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
    <div class="d-flex align-items-center">
        <img src="{{ asset('/images/' . auth()->user()->channel->image) }}" class="rounded-circle" style="height: 40px;">
        <input type="text" wire:model="body" class="my-2 comment-form-control" placeholder="新增留言...">
    </div>

    <div class="d-flex justify-content-end align-items-center">
        @if ($body)
        <a href="" wire:click.prevent="resetForm">取消</a>
        <a href="" class="mx-2 btn btn-secondary" wire:click.prevent="addComment">送出</a>
        @endif
    </div>
</div>
