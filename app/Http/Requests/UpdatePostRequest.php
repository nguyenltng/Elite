<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
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
            'title'     => 'bail|required',
            'description'    => 'bail|required',
            'link' => 'bail|required',
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
            'title.required' => 'Vui lòng tiêu đề cho bài đăng.',
            'description.required' => 'Vui lòng nhập mô tả.',
            'link.required' => 'Vui lòng đường dẫn.'
        ];
    }
}
