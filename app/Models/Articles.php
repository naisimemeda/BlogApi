<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;

class Articles extends Model
{
    protected $fillable = [
        'title', 'content', 'user_id', 'comment_count', 'up_count'
    ];

    public function scopeWithOrder($query, $order)
    {
        // 不同的排序，使用不同的数据读取逻辑
        switch ($order) { 
            case '1':
                $query->orderBy('updated_at', 'desc');
                break;
            case '2':
                $query->orderBy('like_count', 'desc');
                break;
            case '3':
                $query->orderBy('created_at', 'asc');
                break;
            case '4':
                $query->where('comment_count', 0)->orderBy('created_at', 'desc');
                break;
        }
        return $query->with('user');
    }
    public function User()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function Like(){
        return $this->belongsToMany(User::class, 'like', 'article_id', 'user_id')->withTimeStamps ();
    }

    public function comments(){
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function UpLike($user_id)
    {
        if ( ! is_array($user_id)) {
            $user_id = compact('user_id');
        }
        $this->Like()->sync($user_id, false);
    }

    public function unLike($user_id)
    {
        if ( ! is_array($user_id)) {
            $user_id = compact('user_id');
        }
        $this->Like()->detach($user_id);
    }

    public function isLike($user_id)
    {
        return $this->Like->contains($user_id);
    }


}
