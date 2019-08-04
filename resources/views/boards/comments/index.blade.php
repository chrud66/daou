<div id="comment_wrap">
    <div class="border-bottom border-info">
        <h4>
            댓글
            @if($board->comments_count > 0)
            [총 {{ $board->comments_count }}개의 댓글이 있습니다.]
            @endif
        </h4>
    </div>
    @include('boards.comments.partial.create')

    <hr style="border-top: 3px solid #3490dc;" class="mt-0">

    <div class="container">
        @forelse($comments as $comment)
            @include('boards.comments.partial.comment', ['parentId' => $comment->id])
        @empty
        <div class="card text-white bg-dark border-white mb-3">
            <div class="card-body">
                <p class="card-text">등록된 댓글이 없습니다.</p>
            </div>
        </div>
        @endforelse
    </div>
</div>

@section('script')
<script>
    $('a.comment_reply').on('click', function () {
        var replyForm   = $(this).siblings('div.comment_create').first(),
            editForm    = $(this).siblings('div.comment_edit').first();

        editForm.hide('fast');
        replyForm.toggle('fast').end().find('textarea').focus();
    });

    $('a.comment_edit').on('click', function () {
        var replyForm   = $(this).siblings('div.comment_create').first(),
            editForm = $(this).siblings('div.comment_edit').first();

        replyForm.hide('fast');
        editForm.toggle('fast').end().find('textarea').focus();
    });
</script>
@endsection
