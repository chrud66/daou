@if(Route::current()->getName() !== 'boards.create' && Route::current()->getName() !== 'boards.edit')
    <a href="{{ route('boards.create') }}" class="btn btn-primary ml-auto">
        글쓰기
    </a>
@endif

@if(Route::current()->getName() === 'boards.show')
    <a href="{{ route('boards.index', ['page' => $page]) }}" class="btn btn-primary ml-auto">
        목록
    </a>

    @can('update', $board)
    <a href="{{ route('boards.edit', ['id' => $board->id, 'page' => $page]) }}" class="btn btn-success ml-auto">
        수정
    </a>
    @endcan

    @can('delete', $board)
        <form action="{{ route('boards.destroy', ['id' => $board->id, 'page' => $page]) }}" method="post" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger ml-auto">삭제</button>
        </form>
    @endcan
@endif
