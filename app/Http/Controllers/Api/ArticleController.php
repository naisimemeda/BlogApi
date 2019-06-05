<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\ArticleRequest;
use App\Models\Articles;
use App\Models\User;
use Illuminate\Http\Request;

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
        $res = $articles->toArray();
        $res['created_at'] = $articles->created_at->diffForHumans();
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
