@extends('layouts.app')

@section('title')
    - 게시판 목록
@endsection

@section('content')
    <div class="container bg-white p-3 rounded-lg">
        @include('boards.partial.title')

        <div class="row justify-content-center">
            <article class="container p-3">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="text-center" scope="col" style="width: 10%">No</th>
                            <th class="text-center" scope="col" style="width: 50%">제목</th>
                            <th class="text-center" scope="col" style="width: 20%">작성자</th>
                            <th class="text-center" scope="col" style="width: 20%">작성일시</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($boards as $index => $board)
                            <tr>
                                <th class="text-center" scope="row">{{ $startNumber - $index }}</th>
                                <td class="title">
                                    <a href="{{ route('boards.show', array_merge(['id' => $board->id], request()->except(''))) }}" class="title font-weight-bold d-flex">
                                        {{ $board->subject }}
                                        @if($board->comments_count > 0)
                                            [{{ $board->comments_count }}]
                                        @endif
                                    </a>
                                </td>
                                <td class="text-center">{{ $board->author->name }}</td>
                                <td class="text-center">{{ $board->created_at }}</td>
                            </tr>
                        @empty
                            <tr>
                                <th class="text-center" scope="row" colspan="4">작성된 글이 없습니다.</th>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div>
                    <div class="input-group mb-3 flex-row">
                        <form action="{{ route('boards.index') }}" method="get" style="display: inherit;">
                            <input type="text" class="form-control" name="search" placeholder="검색어" aria-label="검색어" aria-describedby="button-addon2" required value="{{ request()->get('search', '') }}">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="submit" id="button-addon2">검색</button>
                            </div>
                        </form>
                    </div>
                    <div>

                    </div>
                    <div class="d-flex justify-content-center">
                        {!! $boards->appends(request()->except('page'))->links() !!}
                    </div>
                </div>
            </article>
        </div>
    </div>
@endsection
