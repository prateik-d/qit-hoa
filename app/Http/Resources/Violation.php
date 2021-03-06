<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Violation extends JsonResource
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
            'user_id' => $this->user_id,
            'violation_type_id' => $this->violation_type_id,
            'description' => $this->description,
            'violation_date' => $this->violation_date,
            'approved_by' => $this->approved_by,
            'moderator_commment' => $this->moderator_commment,
            'user_reply' => $this->user_reply,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
