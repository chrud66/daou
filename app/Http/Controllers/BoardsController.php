<?php

namespace App\Http\Controllers;

use App\Board;
use App\BoardFile;
use App\Comment;
use App\Http\Requests\BoardsRequest;
use Auth;
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
        $tag      = 'boards';
        $cacheKey = 'boards.index.' . urlencode(request()->fullUrl());

        if(checkCash($tag, $cacheKey)) {
            $boards = getCash($tag, $cacheKey);
        } else {
            $query = Board::with('author')->withCount('comments');
            if(request()->get('search')) {
                $query->where('subject', 'like', '%'. request()->get('search').'%');
            }
            $boards = $query->orderByDesc('created_at')->paginate(10);
            putCache($tag, $cacheKey, $boards, 600);
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

        flushCache('boards');

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
        $tag        = 'board.show';
        $cacheKey   = 'boards.show.' . urlencode(request()->fullUrl());

        if(checkCash($tag, $cacheKey)) {
            $board = getCash($tag, $cacheKey);
        } else {
            $board = Board::with('files', 'author')->withCount('comments')->findOrFail($id);
            putCache($tag, $cacheKey, $board, 600);
        }

        $tag        = 'show.comments';
        $cacheKey   = 'boards.show.comments.' . urlencode(request()->fullUrl());

        if(checkCash($tag, $cacheKey)) {
            $comments = getCash($tag, $cacheKey);
        } else {
            $comments = $board->comments()
                ->leftJoin('users', 'comments.author_id', 'users.id')
                ->select('comments.*', 'users.name')
                ->whereNull('parent_id')
                ->withTrashed()
                ->get();

            putCache($tag, $cacheKey, $comments, 600);
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
        flushCache(['boards', 'board.show', 'show.comments']);

        $urlData = ['id' => $board->id, 'search' => $request->get('search'), 'page' => $request->get('page')];
        return redirect(route('boards.show', $urlData));
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

        flushCache();

        return redirect(route('boards.index', ['page' => $request->get('page')]));
    }
}
