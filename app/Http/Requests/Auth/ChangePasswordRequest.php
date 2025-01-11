<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChangePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true; // Xác nhận quyền truy cập cho request này
    }

    public function rules()
    {
        return [
            'old_password' => 'required|string|min:8',
            'new_password' => 'required|string|min:8|different:old_password',
            'confirm_password' => 'required|string|min:8|same:new_password',
        ];
    }

    /**
     * Thông báo lỗi tùy chỉnh.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'old_password.required' => 'Mật khẩu cũ là bắt buộc.',
            'old_password.min' => 'Mật khẩu cũ phải có ít nhất 8 ký tự.',
            'new_password.required' => 'Mật khẩu mới là bắt buộc.',
            'new_password.min' => 'Mật khẩu mới phải có ít nhất 8 ký tự.',
            'new_password.different' => 'Mật khẩu mới phải khác mật khẩu cũ.',
            'confirm_password.required' => 'Xác nhận mật khẩu là bắt buộc.',
            'confirm_password.min' => 'Xác nhận mật khẩu phải có ít nhất 8 ký tự.',
            'confirm_password.same' => 'Mật khẩu xác nhận không khớp với mật khẩu mới.',
        ];
    }
    public function validateResolved()
    {
        parent::validateResolved(); // Gọi method của parent sau khi làm các kiểm tra tùy chỉnh

        // Kiểm tra mật khẩu hiện tại
        if (!Hash::check($this->input('old_password'), Auth::user()->password)) {
            $validator = $this->getValidatorInstance();
            $validator->errors()->add('old_password', 'Mật khẩu hiện tại không chính xác.');
            $this->failedValidation($validator); // Gọi lỗi validation khi mật khẩu cũ không chính xác
        }
    }
}
