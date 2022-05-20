<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVotingRequest extends FormRequest
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
            'voting_category_id' => 'required_without_all:title',
            'title' => 'required_without_all:voting_category_id',
            'description' => 'required',
            'year' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_datetime',
            'vote_option' => 'required',
            'option' => 'required'
        ];
    }
}
