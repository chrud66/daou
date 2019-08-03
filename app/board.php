<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    protected $fillable = [
        'author_id',
        'subject',
        'content',
    ];

    protected $hidden = [
        'author_id',
    ];

    /* 관계 설정 */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function files()
    {
        return $this->hasMany(BoardFile::class, 'board_id');
    }    
}
