<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Booking_detail;
use App\Models\Car;
use App\Models\DamageReport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingManageController extends Controller
{
    public function index()
    {
        $bookings = Booking::orderBy('created_at', 'desc')->get();
        return view('admin.bookings.listbookings', compact('bookings'));
    }
    public function booking_detail($bookingId)
    {
        $bookingDetail = Booking_detail::findOrFail($bookingId);
        return view('admin.bookings.booking_detail', compact('bookingDetail'));
    }
    public function updatePickupStatus(Request $request, $id)
    {
        $booking = Booking_detail::findOrFail($id);
        $booking->pickup_status = $request->input('status');
        $booking->save();
        return redirect()->back()->with('success', 'Cập nhật trạng thái thành công.');
    }
    public function listRentedCars()
    {

        if (Auth::user()->role === 'admin') {
            $rentedBookings = Booking_detail::where('return_status', '!=', 'Thành công')->where('pickup_status', '!=', 'Đã hủy')
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $user = Auth::user();
            $userCars = Car::where('user_id', $user->id)->get();
            $rentedBookings = Booking_detail::whereIn('car_id', $userCars->pluck('id'))
                ->where('pickup_status', '!=', 'Đã hủy')
                ->where('return_status', '!=', 'Thành công')
                ->orderBy('created_at', 'desc')
                ->get();
        }
        return view('admin.bookings.rentalCars', compact('rentedBookings'));
    }
    public function returnCarPage()
    {
        if (Auth::user()->role === 'admin') {
            $listbookingDetails = Booking_detail::where('pickup_status', 'Thành công')
                ->where(function ($query) {
                    $query->where('return_status', '!=', 'Thành công')
                        ->orWhereNull('return_status');
                })
                ->get();
        } else {
            $user = Auth::user();
            $userCars = Car::where('user_id', $user->id)->pluck('id');
            $listbookingDetails = Booking_detail::whereIn('car_id', $userCars)
                ->where('pickup_status', 'Thành công')
                ->where(function ($query) {
                    $query->where('return_status', '!=', 'Thành công')
                        ->orWhereNull('return_status');
                })
                ->get();
        }

        return view('admin.bookings.listReturnCar', compact('listbookingDetails'));
    }

    public function showReturnCarDetail($id)
    {
        $bookingDetail = Booking_detail::findOrFail($id);

        return view('admin.bookings.returnCarDetail', compact('bookingDetail'));
    }
    public function updateReturnStatus(Request $request, $id)
    {
        $bookingDetail = Booking_detail::findOrFail($id);
        $bookingDetail->return_status = $request->status;
        $bookingDetail->save();
        return redirect()->back()->with('success', 'Trạng thái đã được cập nhật');
    }
    public function storeDamageReport(Request $request, $bookingDetailId)
    {
        $bookingDetail = Booking_detail::findOrFail($bookingDetailId);
        DamageReport::create([
            'booking_detail_id' => $bookingDetail->id,
            'user_id' => $bookingDetail->booking->user_id,
            'damage_description' => $request->damage_description,
            'damage_cost' => $request->damage_cost,
            'payment_status' => $request->payment_status,
        ]);

        return redirect()->route('admin.damageReports.index')->with('success', 'Đơn hư hỏng đã được tạo thành công.');
    }
    public function generateInvoice($bookingId)
    {
        $booking = Booking::with('user', 'booking_detail.car')->findOrFail($bookingId);
        $pdf = PDF::loadView('admin.bookings.invoice', compact('booking'));
        return $pdf->stream('Hóa đơn thuê xe' . $booking->id . '.pdf');
    }
}
