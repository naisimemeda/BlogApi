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
        $comments = New Comment([
            'content' => $request->get('content'),
        ]);
        $comments->commentable()->associate($article);
        $comments->user()->associate(User::UserInfo());
        $comments->save();
        return $this->setStatusCode(200)->success('成功');
    }

    public function show(Articles $article){
        $result = $article->comments()->with(['user'])->get();
        return $this->setStatusCode(200)->success($result);
    }

    public function delete(Comment $comment){
        $this->authorize('delete', $comment);
        $comment->delete();
        return $this->setStatusCode(201)->success('成功');
    }
}
