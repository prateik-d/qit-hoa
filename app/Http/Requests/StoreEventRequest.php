<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'event_category_id' => 'required',
            'organized_by' => 'nullable',
            'event_location_id' => 'required',
            'event_title' => 'required',
            'event_description' => 'required',
            'start_datetime' => 'required|date',
            'end_datetime' => 'required|date|after_or_equal:start_datetime',
            'contact_phone' => 'required',
            'contact_email' => 'required',
            'fb_url' => 'required',
            'twitter_url' => 'required',
            'no_of_rsvp' => 'required',
        ];
    }
}
