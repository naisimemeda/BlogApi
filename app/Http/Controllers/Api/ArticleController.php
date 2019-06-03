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
        Articles::create($data);
        return $this->setStatusCode(201)->success('成功');
    }
}
