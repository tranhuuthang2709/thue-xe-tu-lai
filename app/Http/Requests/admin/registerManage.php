<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class registerManage extends FormRequest
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
    public function rules()
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'phone_number' => 'required|regex:/^\d{10}$/',
            'password' => 'required|string|min:6'
        ];
    }

    /**
     * Tùy chỉnh thông báo lỗi
     *
     * @return array
     */
    public function messages()
    {
        return [
            'first_name.required' => 'Họ là bắt buộc.',
            'last_name.required' => 'Tên là bắt buộc.',
            'email.required' => 'Email là bắt buộc.',
            'email.email' => 'Email phải có định dạng hợp lệ.',
            'email.unique' => 'Email này đã được đăng ký.',
            'phone_number.required' => 'Số điện thoại là bắt buộc.',
            'phone_number.regex' => 'Số điện thoại phải gồm 10 chữ số.',
            'password.required' => 'Mật khẩu là bắt buộc.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
        ];
    }
}
