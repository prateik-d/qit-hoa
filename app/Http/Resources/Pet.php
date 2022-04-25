<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Pet extends JsonResource
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
            'owner_id' => $this->owner_id,
            'pet_type_id' => $this->pet_type_id,
            'breed_id' => $this->breed_id,
            'pet_name' => $this->pet_name,
            'gender' => $this->gender,
            'date_of_birth' => $this->date_of_birth,
            'description' => $this->description,
            'allergies' => $this->allergies,
            'photo' => $this->photo,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
