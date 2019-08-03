<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BoardFile extends Model
{
    protected $fillable = [
        'real_name',
        'save_name',
        'order',
    ];

    protected $hidden = [
        'board_id',
    ];

    /* 관계 설정 */
    public function board()
    {
        return $this->belongsTo(Board::class);
    }
}
