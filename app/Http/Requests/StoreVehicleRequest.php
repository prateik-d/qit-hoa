<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVehicleRequest extends FormRequest
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
            'vehicle_make_id' => 'required',
            'vehicle_model_id' => 'required',
            'vehicle_color_id' => 'required',
            'license_plate_no' => 'required',
            'toll_tag_no' => 'required',
            'toll_tag_type' => 'required',
            'application_date' => 'required',
        ];
    }
}
