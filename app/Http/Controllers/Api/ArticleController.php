<?php

namespace App\Http\Controllers\Api;

use App\Events\ArticleLike;
use App\Http\Requests\Api\ArticleRequest;
use App\Models\Articles;
use App\Models\Like;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{

    public function List(Request $request){
        $res =  Articles::withOrder($request->order)->paginate(15);
        return $this->setStatusCode(201)->success($res);

    }

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

    public function ArticleLike(Articles $articles){
        $user_id = User::UserID();
        $articles->increment('like_count');
        $isLike = $articles->isLike($user_id);
        if(!$isLike){
            $articles->UpLike($user_id);
        }
//        event(new ArticleLike($articles->id, $user_id));
        return $this->setStatusCode(201)->success('成功');
    }

    public function CancelLike(Articles $articles){
        $user_id = User::UserID();
        DB::transaction(function ($query) use ($articles, $user_id){
            $articles->decrement('like_count');
            $articles->unLike($user_id);
        });
        return $this->setStatusCode(201)->success('成功');
    }

    public function Search(Request $request){
        $Search = $request->search;
        $like = '%'.$Search.'%';
        $builder = Articles::query();
        $res = $builder->withOrder($request->order)->where(function ($query) use ($like){
            $query->where('title', 'like', $like)
                ->orWhere('content', 'like', $like);
        })->get();
        return $this->setStatusCode(201)->success($res);
    }
}
