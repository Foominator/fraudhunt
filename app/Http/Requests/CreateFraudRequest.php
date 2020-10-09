<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateFraudRequest extends FormRequest
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
            'name' => 'string|required|min:3',
            'comment' => 'string|required',
            'phone' => 'digits:10|required|unique:phones,number',
            'cards' => 'array',
            'cards.*' => 'string|min:16|max:16',
        ];
    }
}
