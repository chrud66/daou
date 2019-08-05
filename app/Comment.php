<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'author_id',
        'board_id',
        'parent_id',
        'content',
    ];

    protected $hidden = [
        'author_id',
        'board_id',
        'parent_id',
        'deleted_at',
    ];

    protected $dates = [
        'deleted_at',
    ];

    /* Relationships */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function board()
    {
        return $this->belongsTo(Board::class, 'board_id');
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

}
