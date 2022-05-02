<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreViolationRequest extends FormRequest
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
            'user_id'=> 'required',
            'violation_type_id'=> 'required',
            'description'=> 'required',
            'violation_date'=> 'required|date',
            'documents.*' => 'mimes:jpg,jpeg,bmp,png,pdf,xlsx',
            'documents' => 'max:5',
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
            "documents.max" => "file can't be more than 5."
        ];
    }
}
