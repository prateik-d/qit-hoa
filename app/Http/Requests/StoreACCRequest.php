<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreACCRequest extends FormRequest
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
            'title' => 'required',
            'user_id' => 'required',
            'neighbour_id' => 'required|max:4',
            'improvement_details' => 'required',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            "neighbour_id.max" => "approval can be send up to 4 neighbours."
        ];
    }
}
