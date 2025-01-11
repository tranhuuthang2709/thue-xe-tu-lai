<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Xác định xem người dùng có quyền thực hiện yêu cầu này hay không.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Bạn có thể thay đổi để kiểm tra quyền của người dùng, ví dụ nếu người dùng đã đăng nhập.
    }

    /**
     * Lấy các quy tắc xác thực cho yêu cầu.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'phone_number' => 'required|digits_between:10,15',
            'address' => 'nullable|string|max:255',
        ];
    }

    /**
     * Tùy chỉnh thông báo lỗi.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'first_name.required' => 'Vui lòng nhập họ của bạn.',
            'first_name.string' => 'Họ phải là một chuỗi ký tự.',
            'last_name.required' => 'Vui lòng nhập tên của bạn.',
            'last_name.string' => 'Tên phải là một chuỗi ký tự.',
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Địa chỉ email không hợp lệ.',
            'email.unique' => 'Email này đã được sử dụng.',
            'phone_number.required' => 'Vui lòng nhập số điện thoại.',
            'phone_number.digits_between' => 'Số điện thoại phải không đúng định dạng.',
            'address.string' => 'Địa chỉ phải là một chuỗi ký tự.',
        ];
    }
}
