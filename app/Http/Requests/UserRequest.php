<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class UserRequest extends FormRequest
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
        //strict：長すぎる
        //rfc：書式
        //dns：有効ドメイン
        //spoof：なりすましはいじょ
        //
        return [
            'name'=>'required|max:30',
            //'email'=>'required|dns,spoof',
            'email'=>'required',
            'logo_url'=>'max:1024|mimes:jpg,jpeg,png,gif'
        ];

    }

    public function messages(){
        return [
            'name.required'=>'名前は必須です',
            'name.max'=>'名前は30文字までです',
            'email.required'=>'不正アドレス',
            'logo_url.max'=>'1Mbyteまでです',
            'logo_url.mimes'=>'jpg,jpeg,png,gifだけ'
        ];
    }

}
