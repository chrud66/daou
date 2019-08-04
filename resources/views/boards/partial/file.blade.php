<div class="text-muted mt-5">
    <ul class="list-group">
        @forelse($board->files as $file)
            <li class="list-group-item">
                <a href="{{ route('boards.download', $file->id) }}" title="다운로드 - {{ $file->real_name }}">
                    {{ $file->real_name }}
                </a>
            </li>
        @empty
        @endforelse
    </ul>
</div>
