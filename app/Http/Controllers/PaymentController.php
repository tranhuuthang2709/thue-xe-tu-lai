<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Booking_detail;
use App\Models\Car;
use App\Models\Cart;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function vnpay_payment(Request $request)
    {

        $paymentMethod = $request->input('payment_method');
        $cart = Cart::where('user_id', Auth::id())->get();
        foreach ($cart as $item) {
            $pickup_date = $item->pickupAddress->pickup_time;
            $return_date = $item->returnAddress->return_time;
            $exists = Booking_detail::checkBookingDateConflict($item->car_id, $pickup_date, $return_date);
            if ($exists == 'true') {
                return redirect()->back()->with('error', 'Xe ' . $item->car->name . ' đã có người thuê trong khoảng thời gian này.');
            }
        }

        if ($paymentMethod === 'COD') {
            DB::beginTransaction();
            try {
                $booking = new Booking();
                $booking->user_id = Auth::id();
                $booking->payment_method = 'Tiền mặt';
                $booking->total_amount = $request->totalPrice;
                $booking->status = 'Chưa thanh toán';
                $booking->save();

                $cart = Cart::where('user_id', Auth::id())->get();
                foreach ($cart as $item) {
                    Booking_detail::create([
                        'order_id' => $booking->id,
                        'car_id' => $item->car_id,
                        'pickup_address_id' => $item->pickup_address_id,
                        'return_address_id' => $item->return_address_id,
                        'rental_price' => $item->car->discounted_price ? $item->car->discounted_price : $item->car->price,
                        'pickup_status' => 'Đang xử lý',
                        'pickup_type' => $item->pickup_type,
                        'rental_days' => $item->rental_days

                    ]);
                }
                DB::commit();
                Cart::where('user_id', Auth::id())->delete();
                return redirect()->route('user.bookings')->with('success', 'Thuê xe thành công');
            } catch (\Exception $e) {
                DB::rollback();
                return redirect()->route('cart.index')->with('error', $e->getMessage());
            }
        } else if ($paymentMethod === 'VNPAY') {
            $vnp_Url = env('VNPAY_URL');
            $vnp_Returnurl = route('vnpay_return');
            $vnp_TmnCode = env('VNPAY_MERCHANT_CODE');
            $vnp_HashSecret = env('VNPAY_HASH_SECRET');

            $vnp_TxnRef = time();
            $vnp_OrderInfo = 'Thanh toán đơn hàng';
            $vnp_OrderType = 'Bill Payment';
            $vnp_Amount = $request->totalPrice * 100;
            $vnp_Locale = 'vn';
            $vnp_BankCode = 'NCB';
            $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

            $inputData = array(
                "vnp_Version" => "2.1.0",
                "vnp_TmnCode" => $vnp_TmnCode,
                "vnp_Amount" => $vnp_Amount,
                "vnp_Command" => "pay",
                "vnp_CreateDate" => date('YmdHis'),
                "vnp_CurrCode" => "VND",
                "vnp_IpAddr" => $vnp_IpAddr,
                "vnp_Locale" => $vnp_Locale,
                "vnp_OrderInfo" => $vnp_OrderInfo,
                "vnp_OrderType" => $vnp_OrderType,
                "vnp_ReturnUrl" => $vnp_Returnurl,
                "vnp_TxnRef" => $vnp_TxnRef
            );

            if (isset($vnp_BankCode) && $vnp_BankCode != "") {
                $inputData['vnp_BankCode'] = $vnp_BankCode;
            }

            ksort($inputData);
            $query = "";
            $i = 0;
            $hashdata = "";
            foreach ($inputData as $key => $value) {
                if ($i == 1) {
                    $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                } else {
                    $hashdata .= urlencode($key) . "=" . urlencode($value);
                    $i = 1;
                }
                $query .= urlencode($key) . "=" . urlencode($value) . '&';
            }

            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= "?" . $query . 'vnp_SecureHash=' . $vnpSecureHash;
            return redirect($vnp_Url);
        }
    }

    public function vnpay_return(Request $request)
    {
        $vnp_HashSecret = env('VNPAY_HASH_SECRET');
        $inputData = $request->all();
        $vnp_SecureHash = $inputData['vnp_SecureHash'];
        unset($inputData['vnp_SecureHash']);
        $paymentInfo = session()->get('vnp_payment_info');
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
        if ($secureHash == $vnp_SecureHash) {
            if ($inputData['vnp_ResponseCode'] == '00') {
                DB::beginTransaction();
                try {
                    $booking = new Booking();
                    $booking->user_id = Auth::id();
                    $booking->payment_method = 'VNPAY';
                    $booking->total_amount = $inputData['vnp_Amount'] / 100;
                    $booking->status = 'Thành công';
                    $booking->save();

                    $cart = Cart::where('user_id', Auth::id())->get();
                    foreach ($cart as $item) {
                        Booking_detail::create([
                            'order_id' => $booking->id,
                            'car_id' => $item->car_id,
                            'pickup_address_id' => $item->pickup_address_id,
                            'return_address_id' => $item->return_address_id,
                            'rental_price' => $item->car->discounted_price ? $item->car->discounted_price : $item->car->price,
                            'pickup_status' => 'Đang xử lý',
                            'pickup_type' => $item->pickup_type,
                            'rental_days' => $item->rental_days
                        ]);
                    }
                    DB::commit();
                    Cart::where('user_id', Auth::id())->delete();
                    return redirect()->route('user.bookings')->with('success', 'Giao dịch thành công');
                } catch (\Exception $e) {
                    DB::rollback();
                    return redirect()->route('cart.index')->with('error', 'Giao dịch không thành công: ' . $e->getMessage());
                }
            } else {
                return redirect()->route('cart.index')->with('error', 'Giao dịch không thành công. Mã lỗi: ' . $inputData['vnp_ResponseCode']);
            }
        } else {
            return redirect()->route('cart.index')->with('error', 'Giao dịch không hợp lệ');
        }
    }
}
