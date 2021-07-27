<div>
    {{-- Nothing in the world is as soft and yielding as water. --}}
    <h1>{{ $channel->name }}</h1>
    @if($channel->image)
    <img src="{{ asset('images'. '/' . $channel->image) }}" />
    @endif
    <form wire:submit.prevent="update">
        <div class="form-group">
            <label for="">名稱</label>
            <input type="text" wire:model="channel.name" class="form-control">
        </div>
        @error('channel.name')
        <div class="alert alert-danger">
            {{ $message }}
        </div>
        @enderror

        <div class="form-group">
            <label for="">網址</label>
            <input type="text" wire:model="channel.slug" class="form-control">
        </div>
        @error('channel.slug')
        <div class="alert alert-danger">
            {{ $message }}
        </div>
        @enderror

        <div class="form-group">
            <label for="">描述</label>
            <textarea wire:model="channel.description" cols="30" rows="4" class="form-control">
            </textarea>
        </div>
        @error('channel.description')
        <div class="alert alert-danger">
            {{ $message }}
        </div>
        @enderror

        <div class="form-group">
            <input type="file" wire:model="image">
        </div>
        <div class="form-group">
            @if($image)
            <img src="{{ $image->temporaryUrl() }}" class="img-thumbnail">
            @endif
        </div>
        @error('image')
        <div class="alert alert-danger">
            {{ $message }}
        </div>
        @enderror

        <div class="form-group">
            <button type="submit" class="btn btn-primary">更新</button>
        </div>

        @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
        @endif
    </form>
</div>
