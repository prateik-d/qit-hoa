<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Event extends JsonResource
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
            'event_category_id'=> $this->event_category_id,
            'organized_by'=> $this->organized_by,
            'event_location_id'=> $this->event_location_id,
            'event_title'=> $this->event_title,
            'event_description'=> $this->event_description,
            'start_datetime'=> $this->start_datetime,
            'end_datetime'=> $this->end_datetime,
            'contact_phone1' => $this->contact_phone1,
            'contact_email1' => $this->contact_email1,
            'contact_phone2' => $this->contact_phone2,
            'contact_email2' => $this->contact_email2,
            'contact_phone3' => $this->contact_phone3,
            'contact_email3' => $this->contact_email3,
            'fb_url'=> $this->fb_url,
            'twitter_url'=> $this->twitter_url,
            'no_of_rsvp'=> $this->no_of_rsvp,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
