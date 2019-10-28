<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
            'content' => 'required',
            'category_id' => 'nullable',
            'status' => 'required',
            'views' => 'nullable',
            'is_featured' => 'nullable',
            'image' => 'nullable|image',
            'tags' =>'nullable',
            'date' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'title:required'=>'Поле не может быть пустым!',
            'title:min'=>'Минимальная длина 2 символа!'
        ];
    }
}
