<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\TopicsRequest;
use App\Models\Topics;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    public function index() {
        $topic = Topics::all();
        return $this->setStatusCode(200)->success($topic);
    }

    public function store(TopicsRequest $request) {
        Topics::create($request->all());
        return $this->setStatusCode(201)->success('创建成功');
    }
}
