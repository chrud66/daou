<?php

namespace App\Http\Controllers;

use App\Board;
use App\BoardFile;
use App\Comment;
use App\Http\Requests\BoardsRequest;
use Auth;
use Cache;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;

class BoardsController extends Controller
{
    public function __construct(Request $request) {
        $this->middleware('auth', ['except' => ['index', 'show']]);
        view()->share('page', $request->get('page'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index()
    {
        $cacheKey = 'boards.index.' . urlencode(request()->fullUrl());

        $query = Board::with('author')->withCount('comments');
        if(request()->get('search')) {
            $query->where('subject', 'like', '%'. request()->get('search').'%');
        }

        if(Cache::tags('boards')->has($cacheKey)) {
            $boards = Cache::tags('boards')->get($cacheKey);
        } else {
            $boards = $query->orderByDesc('created_at')->paginate(10);
            Cache::tags('boards')->put($cacheKey, $boards, 600);
        }

        $startNumber = ($boards->total() - $boards->perPage() * ($boards->currentPage()-1));

        return view('boards.index', compact('boards', 'startNumber'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $board = new Board;

        return view('boards.create', compact('board'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BoardsRequest $request
     * @return Response
     */
    public function store(BoardsRequest $request)
    {
        $board = Board::create([
            'author_id' => Auth::user()->id,
            'subject'   => $request->input('subject'),
            'content'   => $request->input('content'),
        ]);

        if($request->has('files')) {
            $boardFiles = BoardFile::whereIn('id', $request->input('files'))->get();
            $boardFiles->each(function ($boardFile) use ($board) {
                $boardFile->board()->associate($board);
                $boardFile->save();
            });
        }

        Cache::tags('boards')->flush();

        return redirect(route('boards.show', $board->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $cacheKey = 'boards.show.' . urlencode(request()->fullUrl());
        if(Cache::tags('show_board')->has($cacheKey)) {
            $board = Cache::tags('show_board')->get($cacheKey);
        } else {
            $board = Board::with('files', 'author')->withCount('comments')->findOrFail($id);
            Cache::tags('show_board')->put($cacheKey, $board, 600);
        }

        $cacheKey = 'boards.show.comments.' . urlencode(request()->fullUrl());
        if(Cache::tags('show_comments')->has($cacheKey)) {
            $comments = Cache::tags('show_comments')->get($cacheKey);
        } else {
            $comments = $board->comments()
                ->leftJoin('users', 'comments.author_id', 'users.id')
                ->select('comments.*', 'users.name')
                ->whereNull('parent_id')
                ->get();
            Cache::tags('show_comments')->put($cacheKey, $comments, 600);
        }

        return view('boards.show', compact('board', 'comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Board $board
     * @return Response
     * @throws AuthorizationException
     */
    public function edit(Board $board)
    {
        $this->authorize('update', $board);

        $boardFiles = $board->files()->orderBy('created_at')->get();

        $boardFiles->each(function ($boardFile) {
            $path = public_path('/storage/board/' . $boardFile->save_name);

            if(File::exists($path)) {
                $boardFile->size = File::size($path);
            };
        });

        return view('boards.edit', compact('board', 'boardFiles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BoardsRequest $request
     * @param Board $board
     * @return Response
     * @throws AuthorizationException
     */
    public function update(BoardsRequest $request, Board $board)
    {
        $this->authorize('update', $board);

        $board->update([
            'subject' => $request->input('subject'),
            'content' => $request->input('content'),
        ]);

        Cache::tags('show_board')->flush();
        Cache::tags('show_comments')->flush();

        return redirect(route('boards.show', ['id' => $board->id, 'page' => $request->get('page')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param BoardsRequest $request
     * @param Board $board
     * @return Response
     * @throws AuthorizationException
     */
    public function destroy(BoardsRequest $request, $id)
    {
        $board = Board::with('files')->findOrFail($id);

        $this->authorize('delete', $board);

        foreach($board->files as $boardFile)  {
            $path = public_path('/storage/board/' . $boardFile->save_name);

            if(File::exists($path)) {
                File::delete($path);
            }
        }

        $board->files()->delete();

        $board->delete();

        Cache::flush();

        return redirect(route('boards.index', ['page' => $request->get('page')]));
    }
}
