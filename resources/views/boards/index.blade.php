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
                        @forelse($lists as $index => $list)
                            <tr>
                                <th class="text-center" scope="row">{{ $startNumber - $index }}</th>
                                <td class="text-center">
                                    <a href="{{ route('boards.show', ['id' => $list->id, 'page'=> $page]) }}" class="title">
                                        {{ $list->subject }}
                                    </a>
                                </td>
                                <td class="text-center">{{ $list->author->name }}</td>
                                <td class="text-center">{{ $list->created_at }}</td>
                            </tr>
                        @empty
                            <tr>
                                <th class="text-center" scope="row" colspan="4">작성된 글이 없습니다.</th>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="d-flex">
                    <div class="m-auto">
                        {!! $lists->render() !!}
                    </div>
                </div>
            </article>
        </div>
    </div>
@endsection
