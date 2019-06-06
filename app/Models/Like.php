<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $table = 'like';

    protected $fillable = [
        'user_id', 'article_id',
    ];
}
