<div id="comment-{{ $comment->id }}" class="card text-white bg-dark border-white @if(!isset($hasChild)) mb-3 @else mb-2 ml-5 rounded-left border-right-0 @endif">
    @if($comment->trashed())
        <div class="card-body">
            <p class="mb-0">삭제된 댓글입니다.</p>
        </div>

        <div class="card-footer text-muted text-right p-0  @if(isset($hasChild)) rounded-left border-right-0 @endif">
            @include('boards.comments.partial.button')
        </div>
    @else
    <div class="card-header d-flex @if(isset($hasChild)) border-right-0 rounded-left @endif">
        <p class="mb-0">작성자 : {{ $comment->name }}</p>
        <p class="mb-0 ml-auto">작성일시 : {{ $comment->created_at }}</p>
    </div>
    <div class="card-body">
        <p class="card-text">{!! nl2br(e($comment->content)) !!} </p>
    </div>

    <div class="card-footer text-muted text-right p-0  @if(isset($hasChild)) rounded-left border-right-0 @endif">
        @include('boards.comments.partial.button')

        @can('update', $comment)
            @include('boards.comments.partial.edit')
        @endcan

        @auth
            @include('boards.comments.partial.create', ['parentId' => $comment->id])
        @endauth
    </div>
    @endif

    @php
        $tag = 'show.comments';
        $cacheKey = 'boards.show.comments.' . $comment->id . urlencode(request()->fullUrl());
        if(checkCash($tag, $cacheKey)) {
            $replys = getCash($tag, $cacheKey);
        } else {
            $replys = $comment->replies()
                ->withTrashed()
                ->leftJoin('users', 'comments.author_id', '=', 'users.id')
                ->select('comments.*', 'users.name')
                ->get();

            putCache($tag, $cacheKey, $replys, 600);
        }
        $child = count($replys);
    @endphp

    @forelse ($replys as $reply)
        @include('boards.comments.partial.comment', [
            'comment' => $reply,
            'hasChild'  => $child
        ])
    @empty
    @endforelse
</div>
