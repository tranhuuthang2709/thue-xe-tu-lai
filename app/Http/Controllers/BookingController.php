<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Booking_detail;
use App\Models\Refund;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function bookings()
    {
        $bookings = Booking::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('user.bookings', compact('bookings'));
    }
    public function bookings_detail($id)
    {
        $bookings_detail = Booking_detail::where('order_id', $id)->get();
        return view('user.bookings_detail', compact('bookings_detail'));
    }
    public function cancelBooking($id)
    {
        $booking = Booking::findOrFail($id);
        foreach ($booking->booking_detail as $bookingDetail) {
            $today = Carbon::now('Asia/Ho_Chi_Minh');
            $startDate = $bookingDetail->pickupAddress->pickup_time;
            $diffInHours = Carbon::parse($startDate)->diffInHours($today);
            if ($diffInHours < 6) {
                return redirect()->route('user.bookings')->with('error', 'Đơn hàng của bạn không thể hủy.');
            }
        }
        if ($booking->status === 'Chưa thanh toán') {
            $booking->status = 'Đã hủy';
            foreach ($booking->booking_detail as $bookingDetail) {
                $bookingDetail->pickup_status = 'Đã hủy';
                $bookingDetail->return_status = 'Đã hủy';
                $bookingDetail->save();
            }
            $booking->save();
            return redirect()->route('user.bookings')->with('success', 'Đơn hàng đã được hủy.');
        } elseif ($booking->status === 'Thành công') {
            $bookingDetail = Booking_detail::where('order_id', $booking->id)->get();
            return view('user.booking_cancel', compact('booking', 'bookingDetail'));
        } else {
            return redirect()->route('user.bookings')->with('error', 'Đơn hàng của bạn không thể hủy.');
        }
    }
    public function submitRefundInfo(Request $request, $bookingId)
    {
        $booking = Booking::findOrFail($bookingId);
        $refundAmount = $booking->total_amount;
        $refundData = [
            'booking_id' => $booking->id,
            'account_name' => $request->input('account_name'),
            'account_number' => $request->input('account_number'),
            'bank_name' => $request->input('bank_name'),
            'refund_amount' => floatval($refundAmount),
            'status' => 'Đã yêu cầu'
        ];

        Refund::create($refundData);

        return redirect()->route('user.bookings')->with('success', 'Yêu cầu hoàn tiền đã được gửi thành công! ');
    }
}
