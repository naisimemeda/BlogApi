<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\CommentRequest;
use App\Models\Articles;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    public function articleStore(Articles $article, CommentRequest $request) {
        $user_id = User::UserID();
        $data = [
            'content' => $request->get('content'),
            'user_id' => $user_id,
        ];
        $res = $article->comments()->create($data);
        return $this->setStatusCode(200)->success($res);
    }

    public function show(Articles $article){
        $where = [
            'commentable_type' => 'App\Models\Articles',
            'commentable_id' => $article->id
        ];
        $res = Comment::with('user')->where($where)->get();
        return $this->setStatusCode(200)->success($res);
    }

    public function delete(Comment $comment){
        $this->authorize('delete', $comment);
        $comment->delete();
        return $this->setStatusCode(201)->success('成功');
    }
}
