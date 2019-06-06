<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\ArticleRequest;
use App\Models\Articles;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    public function store(ArticleRequest $request){
        $data = [
          'title' => $request->title,
          'content' => $request->get('content'),
          'user_id' => User::UserID()
        ];
        $res = Articles::create($data);
        return $this->setStatusCode(201)->success($res);
    }

    public function index(Articles $articles){
        $res = Articles::with(['user', 'like:user_id,avatar'])->find($articles->id);
        return $this->setStatusCode(200)->success($res);
    }

    public function update(ArticleRequest $request, Articles $articles){
        $this->authorize('update', $articles);
        $articles->update($request->all());
        return $this->setStatusCode(201)->success($articles->id);
    }

    public function delete(Articles $articles){
        $this->authorize('delete', $articles);
        $articles->delete();
        return $this->setStatusCode(201)->success('成功');
    }
}
