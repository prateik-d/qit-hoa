<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
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
            'role_id'=> $this->role_id,
            'city_id'=> $this->city_id,
            'state_id'=> $this->state_id,
            'reg_code'=> $this->reg_code,
            'first_name'=> $this->first_name,
            'last_name'=> $this->last_name,
            'display_name'=> $this->display_name,
            'email'=> $this->email,
            'mobile_no'=> $this->mobile_no,
            'landline_no'=> $this->landline_no,
            'address'=> $this->address,
            'zip'=> $this->zip,
            'profile_pic' => $this->profile_pic,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
