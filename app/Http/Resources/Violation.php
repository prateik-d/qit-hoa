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
            'id'=> $this->id,
            'user_id'=> $this->user_id,
            'approved_by'=> $this->approved_by,
            'violation_type'=> $this->violation_type,
            'description'=> $this->description,
            'date'=> $this->date,
            'approved_on'=> $this->approved_on,
            'status'=> $this->status,
            'created_at'=> $this->created_at,
            'updated_at'=> $this->updated_at,
        ];
    }
}
