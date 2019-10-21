<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'title'=> 'required|min:2'
        ];
    }

    public function messages()
    {
        return [
            'title:unique'=>'Поле не может быть пустым!',
            'title:min'=>'Минимальная длина 2 символа!'
        ];
    }
}
