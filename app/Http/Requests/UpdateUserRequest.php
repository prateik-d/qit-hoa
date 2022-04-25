<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'id'=> 'required',
            'role_id'=> 'required',
            'city_id'=> 'required',
            'state_id'=> 'required',
            'reg_code'=> 'required',
            'first_name'=> 'required',
            'last_name'=> 'required',
            'display_name'=> 'required',
            'email'=> 'required|email|unique:users,email,'. \Request('id') . ',id',
            'mobile_no'=> 'required',
            'landline_no'=> 'required',
            'address'=> 'required',
            'zip'=> 'required',
            'profile_pic' => 'required',
        ];
    }
}
