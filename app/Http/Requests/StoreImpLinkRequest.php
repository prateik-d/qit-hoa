<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreImpLinkRequest extends FormRequest
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
            'title' => 'required|unique:imp_links,title,' . \Request('id') . ',id',
            'description' => 'required',
            'url' => 'required|unique:imp_links,url,' . \Request('id') . ',id',
            'status' => 'required',
        ];
    }
}
