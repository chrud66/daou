@extends('layouts.app')

@section('title')
    - 게시판 상세 [{{ $board->subject }}]
@endsection

@section('content')
    <div class="container bg-white p-3 rounded-lg">
        @include('boards.partial.title')

        <div class="row justify-content-center">
            <article class="container p-3">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex">
                            <div class="h3 font-weight-bold">
                                {{ $board->subject }}
                            </div>
                            <div class="ml-auto">
                                작성자 : {{ $board->author->name }}
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        @if($board->files->count() > 0)
                            @include('boards.partial.image')
                        @endif

                        <div class="p3">
                            {!! nl2br(e($board->content)) !!}
                        </div>

                        @if($board->files->count() > 0)
                            @include('boards.partial.file')
                        @endif
                    </div>
                </div>
                <div class="d-flex">
                    <div class="m-auto p-2">
                        @include('boards.partial.button')
                    </div>
                </div>
            </article>
        </div>

        <article class="mb-4 p-2">
            @include('boards.comments.index')
        </article>


        <div class="d-flex">
            <div class="m-auto p-2">
                @include('boards.partial.button')
            </div>
        </div>
    </div>

    @can('delete', $board)
        <!-- Modal -->
        <div class="modal fade" id="board_delete_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">게시글 삭제</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        해당 게시물을 삭제하시겠습니까?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">취소</button>
                        <form action="{{ route('boards.destroy', ['id' => $board->id, 'page' => $page]) }}" method="POST" class="d-inline m-0">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-primary">삭제</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endcan
@endsection

