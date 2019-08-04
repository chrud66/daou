<div class="media media_comment comment_edit" style="@if(isset($parentId)) display:none; @else display:block; @endif">
    <div class="media-body p-3">
        <form action="{{ route('comments.update', ['id' => $board->id, 'comment' => $comment->id]) }}" method="post" class="form_create_comment">
            @csrf
            @method('PUT')

            <div class="form-group">
                <textarea name="content" class="col-md-12 form-control @error('content') is-invalid @enderror" rows="3" required>{{ old('content', $comment->content) }}</textarea>

                @error('content')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="text-right">
                @auth
                    <button type="submit" class="btn btn-success btn-sm">
                        저장
                    </button>
                @endauth
            </div>
        </form>
    </div>
</div>
