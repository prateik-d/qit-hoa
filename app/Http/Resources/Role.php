<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Role extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'role_type'=> $this->role_type,
            'permission_id'=> $this->permission_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
