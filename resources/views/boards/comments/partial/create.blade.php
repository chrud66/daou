<div class="media media_comment comment_create" style="@if(isset($parentId)) display:none; @else display:block; @endif">
    <div class="media-body p-3">
        <form action="{{ route('comments.store', $board->id) }}" method="post" class="form_create_comment">
            @csrf

            @if(isset($parentId))
                <input type="hidden" name="parent_id" value="{{ $parentId }}">
            @endif

            <div class="form-group">
                @auth
                    <textarea name="content" class="col-md-12 form-control @error('content') is-invalid @enderror" rows="3" required>{{ old('content') }}</textarea>
                @else
                    <textarea name="content" class="col-md-12 form-control" rows="3" required disabled placeholder="비회원은 댓글을 작성할 수 없습니다. 로그인 해주세요"></textarea>
                @endauth

                @error('content')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="text-right">
                @auth
                    <button type="submit" class="btn btn-success btn-sm">
                        등록
                    </button>
                @endauth
            </div>
        </form>
    </div>
</div>
