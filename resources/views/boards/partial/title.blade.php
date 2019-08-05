<div class="pb-2 mt-4 mb-2 border-bottom d-flex">
    <h3 class="font-weight-bold">
        <a href="{{ route('boards.index') }}" title="게시판"> 게시판 </h3>
    </h3>
    <div class="ml-auto">
        @include('boards.partial.button', ['isTopButton' => 1])
    </div>
</div>
