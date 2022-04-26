<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePetRequest extends FormRequest
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
            'owner_id' => 'nullable',
            'pet_type_id' => 'required',
            'breed_id' => 'required',
            'pet_name' => 'required',
            'gender' => 'required',
            'date_of_birth' => 'required',
            'description' => 'required',
            'allergies' => 'required',
            'photo.*' => 'mimes:jpg,jpeg,bmp,png,pdf,xlsx',
            'photo' => 'max:5',

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
            "photo.max" => "file can't be more than 5."
        ];
    }
}
