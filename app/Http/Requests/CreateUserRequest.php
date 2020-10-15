<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
            'name'     => 'bail|required',
            'email'    => 'bail|required|email',
            'password' => 'bail|required|alphaNum|min:3',
            'passwordConfirm' => 'bail|required|same:password'
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
            'name.required' => 'Vui lòng nhập Email',
            'email.required' => 'Vui lòng nhập mật khẩu.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'passwordConfirm.required' => 'Vui lòng nhập mật khẩu.',
            'password.min' => 'Mật khẩu phải nhiều hơn 3 kí tự.',
            'passwordConfirm.confirmed' => 'Mật khẩu xác thực không đúng.'
        ];
    }
}
