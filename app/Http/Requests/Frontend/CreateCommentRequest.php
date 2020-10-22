<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Lang;

class CreateCommentRequest extends FormRequest
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
            'comment' => 'required|string',
            'phone_id' => 'required|numeric',
            'cards' => 'array',
            'cards.*' => 'string|min:16|max:16',
            'status' => 'required|string|in:approved,declined',
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
            'comment.required' => Lang::get('validation.comment.required'),
            'cards.*.min' => Lang::get('validation.cards.*.min'),
            'cards.*.max' => Lang::get('validation.cards.*.max'),
        ];
    }
}
