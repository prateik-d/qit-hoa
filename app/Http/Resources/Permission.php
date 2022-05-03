<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Permission extends JsonResource
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
            'permission_heading_id'=> $this->permission_heading_id,
            'type'=> $this->type,
            'status'=> $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
