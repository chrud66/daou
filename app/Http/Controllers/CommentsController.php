<?php

namespace App\Http\Controllers;

use Auth;
use App\Board;
use App\Comment;
use App\Http\Requests\CommentsRequest;
use Cache;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CommentsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param CommentsRequest $request
     * @return void
     */
    public function store(CommentsRequest $request, $boardId)
    {
        $board = Board::findOrFail($boardId);

        $createData = [
            'author_id' => Auth::user()->id,
            'board_id'  => $boardId,
            'parent_id' => $request->input('parent_id', null),
            'content'   => $request->input('content')
        ];

        $comment = $board->comments()->with('author')->create($createData);

        flushCache();

        return redirect()->to(url()->previous() . '#comment-' . $comment->id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CommentsRequest $request
     * @param int $id
     * @param Comment $comment
     * @return Response
     * @throws AuthorizationException
     */
    public function update(CommentsRequest $request, $id, Comment $comment)
    {
        $this->authorize('update', $comment);

        $comment->update(['content' => $request->input('content')]);

        flushCache();

        return redirect()->to(url()->previous() . '#comment-' . $comment->id);
    }

    public function destroy(CommentsRequest $request, $id, Comment $comment)
    {
        $this->authorize('delete', $comment);

        $comment->delete();
        flushCache();

        return redirect()->to(url()->previous() . '#comment_wrap');
    }

    public function forceDestroy(CommentsRequest $request, $id, $comment)
    {
        $query = Comment::where('id', '=', $comment)->withTrashed();

        $comment = $query->get();

        $this->authorize('delete', $comment);
        if(!Auth::user()->isAdmin()) {
            abort(403);
        }

        $query->forceDelete();
        flushCache();

        return redirect()->to(url()->previous() . '#comment_wrap');
    }
}
