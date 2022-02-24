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
            'description'=>'required|max:500',
            'image'=>'required|max:1024|mimes:jpg,jpeg,png,gif'
        ];
    }
    public function messages(){
        return [
            'description.required'=>'本文は必須です',
            'description.max'=>'本文は500文字までです',
            'image.required'=>'画像は必須です',
            'image.max'=>'1Mbyteまでです',
            'image.mimes'=>'jpg,jpeg,png,gifだけ'
        ];
    }
}
