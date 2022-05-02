<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'role_id' => 'required',
            'city_id' => 'required',
            'state_id' => 'required',
            'reg_code' => 'required',
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'display_name' => 'required',
            'email' => 'required|email|unique:users',
            'mobile_no' => 'required',
            'landline_no' => 'required',
            'address' => 'required',
            'zip' => 'required|numeric',
            'profile_pic' => 'required',
            'password' => 'required|min:8|max:255',
            'c_password' => 'required|same:password',
        ];
    }
}
