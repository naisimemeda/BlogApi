<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Articles extends Model
{
    protected $fillable = [
        'title', 'content', 'user_id', 'comment_count', 'up_count'
    ];
}
