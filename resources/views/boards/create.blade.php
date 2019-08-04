@extends('layouts.app')

@section('title')
    - 게시판 글쓰기 [{{ $board->subject }}]
@endsection

@section('content')
    <div class="container bg-white p-3 rounded-lg">
        @include('boards.partial.title')

        <div class="row justify-content-center">
            <article class="container p-3">
                <form action="{{ route('boards.store') }}" method="POST" role="form" class="form_board">
                    @csrf

                    @include('boards.partial.form')


                    <div class="form-group">
                        <p class="text-center">
                            @include('boards.partial.button')
                        </p>
                    </div>
                </form>
            </article>
        </div>
    </div>
@endsection
