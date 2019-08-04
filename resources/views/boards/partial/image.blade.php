<ul class="list-unstyled">
    @forelse($board->files as $file)
        <li class="text-center mt-4 mb-4">
            <img src="{{ url('/storage/board/'.$file->save_name) }}" class="img-fluid img">
        </li>
    @empty
    @endforelse
</ul>
