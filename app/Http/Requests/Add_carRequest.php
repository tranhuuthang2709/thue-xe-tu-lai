<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class Add_carRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Bạn có thể thay đổi nếu cần kiểm tra quyền của người dùng
    }

    /**
     * Xác định các quy tắc xác thực cho yêu cầu.
     *
     * @return array
     */
    public function rules()
    {
        return [

            // Kiểm tra pickup_time phải sau ít nhất 2 ngày từ hiện tại
            'pickup_time' => [
                'required',
                'date',
                'after_or_equal:' . Carbon::now()->addDays(1)->format('Y-m-d H:i:s'),
            ],
            'return_time' => 'required|date|after:pickup_time',

            'pickup_province' => 'required_if:pickup_type,Giao xe tận nơi',
            'pickup_district' => 'required_if:pickup_type,Giao xe tận nơi',
            'pickup_ward' => 'required_if:pickup_type,Giao xe tận nơi',
            'pickup_street' => 'required_if:pickup_type,Giao xe tận nơi',

            'return_province' => 'required',
            'return_district' => 'required',
            'return_ward' => 'required',
            'return_street' => 'required',

        ];
    }

    /**
     * Các thông báo lỗi tuỳ chỉnh cho từng quy tắc xác thực.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'pickup_time.required' => 'Vui lòng chọn thời gian.',
            'pickup_time.after_or_equal' => 'Thời gian nhận xe phải lớn hơn 1 ngày kể từ ngày đặt hàng.',
            'return_time.required' => 'Vui lòng chọn thời gian trả xe.',
            'return_time.after' => 'Thời gian trả xe phải sau thời gian nhận xe.',
            'pickup_province.required_if' => 'Vui lòng chọn tỉnh/thành phố.',
            'pickup_district.required_if' => 'Vui lòng chọn quận/huyện.',
            'pickup_ward.required_if' => 'Vui lòng chọn địa chỉ nhận xe.',
            'pickup_street.required_if' => 'Vui lòng nhập số nhà.',
            'return_province.required' => 'Vui lòng chọn tỉnh/thành phố.',
            'return_district.required' => 'Vui lòng chọn quận/huyện.',
            'return_ward.required' => 'Vui lòng chọn xã.',
            'return_street.required' => 'Vui lòng nhập số nhà/tòa nhà trả xe.',
        ];
    }
}
