    @if(!$comment->trashed())
    @auth
        <a href="javascript:;" class="btn btn-success btn-sm mt-3 mb-3 mr-3 comment_reply">답글</a>
    @endauth

    @can('update', $comment)
        <a href="javascript:;" class="btn btn-light btn-sm mt-3 mb-3 mr-3 comment_edit">수정</a>
    @endcan

    @can('delete', $comment)
        <button type="button" class="btn btn-danger btn-sm mt-3 mb-3 mr-3 comment_delete" data-toggle="modal" data-target="#comment_delete_modal{{ $comment->id }}">
            삭제
        </button>

        <!-- Modal -->
        <div class="modal fade" id="comment_delete_modal{{ $comment->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">댓글 삭제</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-left">
                        해당 댓글을 삭제하시겠습니까?<br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">취소</button>
                        <form action="{{ route('comments.destroy', ['id' => $board->id, 'comment' => $comment->id]) }}" method="POST" class="d-inline m-0">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-primary">삭제</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endcan
@endif

@auth
@if(Auth::user()->isAdmin())
    <button type="button" class="btn btn-danger btn-sm mt-3 mb-3 mr-3 comment_delete" data-toggle="modal" data-target="#comment_force_delete_modal{{ $comment->id }}">
        완전삭제
    </button>

    <!-- Modal -->
    <div class="modal fade" id="comment_force_delete_modal{{ $comment->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">댓글 완전삭제</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-left">
                    해당 댓글을 삭제하시겠습니까?<br>
                    하위 댓글들도 모두 함께 삭제됩니다.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">취소</button>
                    <form action="{{ route('comments.forceDestroy', ['id' => $board->id, 'comment' => $comment->id]) }}" method="POST" class="d-inline m-0">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-primary">삭제</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif
@endauth
