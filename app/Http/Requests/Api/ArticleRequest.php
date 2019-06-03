<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function authorize()
    {
        switch ($this->method()) {
            case 'GET':
            case 'POST':
                {

                    return [
                        'title' => ['required', 'max:25'],
                        'content' => ['required'],
                    ];
                }
            case 'PUT':
            case 'PATCH':
            case 'DELETE':
            default:
                {
                    return [

                    ];
                }
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name.required' => '标题不能为空',
            'name.max' => '标题最大长度为25个字符',
        ];
    }
}
