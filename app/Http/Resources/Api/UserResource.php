<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        foreach ($this->article as $k => $v) {
            $v['created_cn'] = $v['created_at']->diffForHumans();
        }
        return [
            'id'=>$this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone'=> $this->phone,
            'sex'=> $this->sex,
            'introduction'=> $this->introduction,
            'status'=> $this->status,
            'notice_count'=> $this->notice_count,
            'avatar'=> $this->avatar,
            'created_at'=> $this->created_at,
            'updated_at'=> $this->avatar,
            'article'=> $this->article,
        ];
    }
}
