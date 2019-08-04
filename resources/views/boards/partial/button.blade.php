@if(Route::current()->getName() !== 'boards.create' && Route::current()->getName() !== 'boards.edit')
    <a href="{{ route('boards.create', request()->except('')) }}" class="btn btn-primary ml-auto">
        글쓰기
    </a>
@endif


@if(Route::current()->getName() === 'boards.show' || Route::current()->getName() === 'boards.create' || Route::current()->getName() === 'boards.edit')
    <a href="{{ route('boards.index', request()->except('')) }}" class="btn btn-primary ml-auto">
        목록
    </a>
@endif

@if(Route::current()->getName() === 'boards.show')
    @can('update', $board)
    <a href="{{ route('boards.edit', ['id' => $board->id, 'page' => $page]) }}" class="btn btn-success ml-auto">
        수정
    </a>
    @endcan

    @can('delete', $board)
        <button type="button" class="btn btn-danger ml-auto" data-toggle="modal" data-target="#board_delete_modal">삭제</button>
    @endcan
@endif

@if(Route::current()->getName() === 'boards.create' || Route::current()->getName() === 'boards.edit')
    <a href="javascript:void(0)" onclick="window.location.reload()" class="btn btn-dark m-2">
        초기화
    </a>

    <button type="submit" class="btn btn-primary m-2">
        저장하기
    </button>
@endif
