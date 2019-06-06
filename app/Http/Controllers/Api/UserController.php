<?php

namespace App\Http\Controllers\Api;

use App\Handlers\ImageUploadHandler;
use App\Http\Requests\Api\UserRequest;
use App\Http\Resources\Api\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //用户注册
    public function store(UserRequest $request){
        User::create($request->all());
        $token = Auth::guard('api')->attempt(['name'=>$request->name,'password'=>$request->password]);
        if($token) {
            return $this->setStatusCode(201)->success([
                'name' => $request->name,
                'avatar' => $request->avatar,
                'token' => 'bearer ' . $token
            ]);
        }
        return $this->failed('注册失败',400);
    }
    //用户登录
    public function login(Request $request){
        $token = Auth::guard('api')->attempt(['name'=>$request->name,'password'=>$request->password]);
        $user = Auth::guard('api')->user();
        $user['token'] = 'bearer ' . $token;
        if($token) {
            return $this->setStatusCode(200)->success($user);
        }
        return $this->failed('账号或密码错误',400);
    }
    //用户退出
    public function logout(){
        Auth::guard('api')->logout();
        return $this->success('退出成功...');
    }
    //返回当前登录用户信息
    public function info(){
        $user = Auth::guard('api')->user();
        return $this->success(new UserResource($user));
    }

    //查询单个用户 以及发布文章总数
    public function UserInfo(User $user){
        return $this->setStatusCode(201)->success($user->loadCount('article'));
    }

    //查询单个用户下面的所有文章
    public function UserArticle(User $user){
        $user = User::with('article')->find($user->id);
        return $this->setStatusCode(201)->success(new UserResource($user));
    }

    public function update(UserRequest $request,User $user){
        $this->authorize('update', $user);
        $user->update($request->all());
        return $this->setStatusCode(201)->success('成功');
    }

    public function Paword(Request $request){
        $user = Auth::guard('api')->user();
        $this->authorize('update', $user);
        $user->update($request->all());
        return $this->setStatusCode(201)->success('成功');
    }

    public function UploadAvatar(Request $request,ImageUploadHandler $uploader){
        $request->validate([
            'avatar' => 'required|mimes:jpeg,bmp,png,gif',
        ]);
        $user = Auth::guard('api')->user();
        $data = $request->all();
        if($request->avatar){
            $request = $uploader->save($request->avatar,'avatars',$user->id,416);
            if($request){
                $data['avatar'] = $request['path'];
                $this->authorize('update',$user);
                $user->update($data);
                return $this->success($data);
            }
        }
    }
}
