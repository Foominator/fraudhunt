<?php

namespace App\Http\Requests\Frontend;

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
            'comment' => 'string|required',
            'phones' => 'array|required|min:1',
            'phones.*' => 'digits:10|required|unique:phones,number',
            'cards' => 'array',
            'cards.*' => 'string|min:16|max:16|unique:cards,card_num',
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
            'digits' => 'Некорректный телефон',
            'phones.*.unique' => 'Мошенник с таким номером уже был создан',

            'cards.*.min' => 'Некорректная длинна банковской карты',
            'cards.*.max' => 'Некорректная длинна банковской карты',
            'cards.*.unique' => 'Банковская карта с таким номером уже была добавлена',
        ];
    }
}
