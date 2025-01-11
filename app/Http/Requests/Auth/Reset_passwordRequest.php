<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class Reset_passwordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    public function rules(): array
    {
        return [
            'new_password' => 'required',
            'confirm_password' => 'required|same:new_password'

        ];
    }
    public function messages(): array
    {
        return [
            'new_password.required' => 'Vui lòng không để trống',
            'confirm_password.required' => 'Vui lòng không để trống',
            'confirm_password.same' => 'Mật khẩu nhập lại không giống với mật khẩu mới'
        ];
    }
}
