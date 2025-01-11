<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Refund;
use Illuminate\Http\Request;

class RefundManageController extends Controller
{
    //hủy
    public function listRefund()
    {
        $listRefund = Refund::orderByDesc('created_at')->get();
        return view('admin.bookings.listRefund', compact('listRefund'));
    }

    public function updateStatusRefund(Request $request, $id)
    {
        $refund = Refund::findOrFail($id);
        $refund->status = $request->input('status');
        $refund->save();
        if ($refund->status === 'Đã hoàn tiền') {
            $booking = Booking::where('id', $refund->booking_id)->first();
            $booking->status = 'Đã hủy';
            $booking->save();
        }
        return redirect()->route('booking.listRefund')->with('success', 'Trạng thái yêu cầu đã được cập nhật.');
    }
}
