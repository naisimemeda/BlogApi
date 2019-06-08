<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public $fillable = [
        'content','user_id','article_id'
    ];

    public function commentable()
    {
        return $this->morphTo();
    }
    public function comments()
    {
        return $this->morphToMany(Comment::class, 'Commentable');
    }

}
