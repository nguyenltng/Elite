<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
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
            'email'    => 'bail|required|email|unique:App\Model\User,email',
            'password' => 'bail|required|alphaNum|min:3',
            'oldPassword' => 'bail|required'
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
            'name.required' => 'Please enter your name',
            'email.required' => 'Please enter your Email.',
            'email.unique' => 'Email was available. Please choice different email!',
            'password.required' => 'Please enter your password.',
            'passwordConfirm.required' => 'Please enter your confirm password.',
            'password.min' => 'Password least 3 char.',
            'passwordConfirm.confirmed' => 'Confirm password dont match with password.'
        ];
    }
}
