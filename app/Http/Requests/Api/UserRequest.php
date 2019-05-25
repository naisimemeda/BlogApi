<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'GET':
                {
                    return [
                        'id' => ['required,exists:shop_user,id']
                    ];
                }
            case 'POST':
                {
                    return [
                        'name' => ['required', 'max:12','unique:users,name'],
                        'password' => ['required', 'max:16', 'min:6'],
                        'email' => ['unique:users,email'],
                        'avatar' => ['required'],
                    ];
                }
            case 'PUT':
            case 'PATCH':
                {
                    return [
                        'avatar' => 'mimes:jpeg,bmp,png,gif|dimensions:min_width=208,min_height=208',
                    ];
                }
            case 'DELETE':
            default:
                {
                    return [

                    ];
                }
        }
    }

    public function messages()
    {
        return [
            'id.required'=>'用户ID必须填写',
            'id.exists'=>'用户不存在',
            'name.unique'=>'用户名已存在',
            'name.required' => '用户名不能为空',
            'name.max' => '用户名最大长度为12个字符',
            'password.required' => '密码不能为空',
            'password.max' => '密码长度不能超过16个字符',
            'password.min' => '密码长度不能小于6个字符',
            'email.unique' => '邮箱已存在'
        ];
    }
}
