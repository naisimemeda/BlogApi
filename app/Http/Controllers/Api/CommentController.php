<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\CommentRequest;
use App\Models\Articles;
use App\Models\User;

class CommentController extends Controller
{
    public function articleStore(Articles $article, CommentRequest $request) {
        $user_id = User::UserID();
        $data = [
            'content' => $request->get('content'),
            'user_id' => $user_id,
        ];
        $article->comments()->create($data);
        return $this->setStatusCode(200)->success('评论成功');
    }

    public function show(Articles $article){
        $res = Articles::with('CommentUser')->find($article->id);
        return $this->setStatusCode(200)->success($res);
    }
}
