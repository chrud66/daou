@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">로그인 후 메인</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="text-center">
                        <a class="btn btn-success" href="{{ url('/boards') }}">게시판 바로가기</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
