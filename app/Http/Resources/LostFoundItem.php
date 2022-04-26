<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LostFoundItem extends JsonResource
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
            'item_id' => $this->item_id,
            'item_title' => $this->item_title,
            'item_type' => $this->item_type,
            'category_id' => $this->category_id,
            'description' => $this->description,
            'date_lost' => $this->date_lost,
            'date_found' => $this->date_found,
            'belongs_to' => $this->belongs_to,
            'found_by' => $this->found_by,
            'claimed_by' => $this->claimed_by,
            'date_claimed' => $this->date_claimed,
            'location' => $this->location,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
