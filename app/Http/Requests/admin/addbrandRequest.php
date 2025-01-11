<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class addbrandRequest extends FormRequest
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
            'name' => 'required|unique:brands,name',
            'image' => 'required'
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Tên thương hiệu là bắt buộc.',
            'name.unique' => 'Tên thương hiệu đã tồn tại.',
            'image.required' => 'Ảnh không được bỏ trống'
        ];
    }
}
