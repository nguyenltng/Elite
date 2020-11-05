<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'posts' => [$this->posts],
            'remember_token' => $this->remember_token,
            'password' => $this->password,
            'created_at' =>  (String)$this->created_at,
            'delete_at' =>  (String)$this->delete_at
        ];
    }
}
