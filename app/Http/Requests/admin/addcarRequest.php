<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class addcarRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Cho phép tất cả người dùng gửi yêu cầu này
    }

    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'main_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'brand_id' => 'required|exists:brands,id',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric',
            'discounted_price' => 'nullable|numeric|lt:price',
            'license_plate' => 'required|max:255|unique:cars,license_plate',
            'manufacture_year' => 'required|numeric|min:1900|max:' . (date('Y') + 1),
            'fuel_type' => 'required',
            'color' => 'required|max:50',
            'transmission' => 'required',
            'status' => 'required',
        ];
    }

    // Nếu cần, bạn có thể thêm các thông báo lỗi ở đây
    public function messages()
    {
        return [
            'name.required' => 'Tên xe không được để trống.',
            'name.max' => 'Tên xe không được vượt quá 255 ký tự.',
            'main_image.required' => 'Ảnh chính không được để trống.',
            'main_image.image' => 'Ảnh chính phải là một hình ảnh.',
            'main_image.mimes' => 'Ảnh chính phải có định dạng jpeg, png, jpg, gif hoặc svg.',
            'main_image.max' => 'Ảnh chính không được vượt quá 2MB.',
            'secondary_image.array' => 'Ảnh chi tiết phải là một mảng.',
            'secondary_image.*.image' => 'Ảnh chi tiết phải là một hình ảnh.',
            'secondary_image.*.mimes' => 'Ảnh chi tiết phải có định dạng jpeg, png, jpg, gif hoặc svg.',
            'secondary_image.*.max' => 'Ảnh chi tiết không được vượt quá 2MB.',
            'brand_id.required' => 'Thương hiệu không được để trống.',
            'category_id.required' => 'Danh mục không được để trống.',
            'price.required' => 'Giá xe không được để trống.',
            'price.numeric' => 'Giá xe phải là một số.',
            'discounted_price.numeric' => 'Giá giảm phải là một số.',
            'discounted_price.lt' => 'Giá giảm phải nhỏ hơn giá xe.',
            'license_plate.required' => 'Biển số xe không được để trống.',
            'license_plate.max' => 'Biển số xe không được vượt quá 255 ký tự.',
            'license_plate.unique' => 'Biển số xe đã tồn tại.',
            'manufacture_year.required' => 'Năm sản xuất không được để trống.',
            'manufacture_year.numeric' => 'Năm sản xuất phải là một số.',
            'manufacture_year.min' => 'Năm sản xuất phải lớn hơn hoặc bằng 1900.',
            'manufacture_year.max' => 'Năm sản xuất không thể lớn hơn năm hiện tại.',
            'fuel_type.required' => 'Loại nhiên liệu không được để trống.',
            'color.required' => 'Màu xe không được để trống.',
            'color.max' => 'Màu xe không được vượt quá 50 ký tự.',
            'transmission.required' => 'Loại hộp số không được để trống.',
            'status.required' => 'Trạng thái không được để trống.',
        ];
    }
}
