<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClassifiedRequest extends FormRequest
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
            'description' => 'required',
            'classified_category_id' => 'required',
            'classified_condition_id' => 'required',
            'asking_price' => 'required',
            'date_posted' => 'required|date',
            'posted_by' => 'required',
            'purchase_by' => 'required',
            'sale_price' => 'required',
        ];
    }
}
