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
                        @forelse($boardFiles as $boardFile)
                            <div class="text-center p-3">
                                <img src="{{ url('/storage/board/'.$boardFile->save_name) }}" class="img-fluid img">
                            </div>
                        @empty
                        @endforelse

                        <div class="p3">
                            {!! nl2br(e($board->content)) !!}
                        </div>
                    </div>
                </div>
                <div class="d-flex">
                    <div class="m-auto p-5">
                        @include('boards.partial.button')
                    </div>
                </div>
            </article>

            <article class="mt-4 mb-4 p-2">
                @include('boards.comments.index')
            </article>
        </div>
    </div>
@endsection
