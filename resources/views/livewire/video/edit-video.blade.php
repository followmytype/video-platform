<div>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-4">
                        <img src="{{ asset($this->video->thumbnail) }}" class="img-thumbnail">
                    </div>
                    <div class="col-md-8">
                        <p>進度：({{ $this->video->processing_percentage }})</p>
                    </div>
                </div>
                <form wire:submit.prevent="update">
                    <div class="form-group">
                        <label>標題</label>
                        <input type="text" wire:model="video.title" class="form-control">
                    </div>
                    @error('video.title')
                    <div class="alert alert-danger">
                        {{ $message }}
                    </div>
                    @enderror

                    <div class="form-group">
                        <label>描述</label>
                        <textarea wire:model="video.description" cols="30" rows="4" class="form-control">
                        </textarea>
                    </div>
                    @error('video.description')
                    <div class="alert alert-danger">
                        {{ $message }}
                    </div>
                    @enderror

                    <div class="form-group">
                        <label>觀看權限</label>
                        <select wire:model="video.visibility" class="form-control">
                            <option value="public">公開</option>
                            <option value="private">私人</option>
                            <option value="unlisted">限制觀看</option>
                        </select>
                    </div>
                    @error('video.vidibility')
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
        </div>
    </div>
</div>
