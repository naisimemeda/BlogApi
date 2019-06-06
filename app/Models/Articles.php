<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Articles extends Model
{

    protected $fillable = [
        'title', 'content', 'user_id', 'comment_count', 'up_count'
    ];

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function Like(){
        return $this->belongsToMany(User::class, 'like', 'article_id', 'user_id');
    }

}
