<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReservationRequest extends FormRequest
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
            'ammenity_id' => 'required',
            'purpose' => 'required',
            'description' => 'required',
            // 'booking_date' => 'required|date',
            'booking_date' => [
                'date_format:Y-m-d',// format without hours, minutes and seconds.
                'after_or_equal:' . date('Y-m-d'), // not 'now' string
            ],
            // 'timeslots' => 'required',
            'booking_price' => 'required',
            'payment_mode' => 'required'
        ];
    }
}
