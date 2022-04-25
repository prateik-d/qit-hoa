<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLostFoundItemRequest extends FormRequest
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
            'item_id' => 'required',
            'item_title' => 'required',
            'item_type' => 'required',
            'category_id' => 'required',
            'description' => 'required',
            'date_lost' => 'required',
            'location' => 'required',
        ];
    }
}
