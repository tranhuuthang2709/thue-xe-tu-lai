<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking_detail;
use App\Models\Car;
use App\Models\DamageReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DamageReportController extends Controller
{
    public function index()
    {
        if (Auth::user()->role === 'admin') {
            $damageReports = DamageReport::all();
        } else {
            $user = Auth::user();
            $userCars = Car::where('user_id', $user->id)->pluck('id');
            $damageReports = DamageReport::whereIn('booking_detail_id', function ($query) use ($userCars) {
                $query->select('id')
                    ->from('bookings_detail')
                    ->whereIn('car_id', $userCars);
            })->get();
        }

        return view('admin.damageReport.listReport', compact('damageReports'));
    }

    public function updatePaymentStatus(Request $request, $id)
    {
        $report = DamageReport::findOrFail($id);
        $report->payment_status = $request->payment_status;
        $report->save();
        return redirect()->back()->with('success', 'Cập nhật trạng thái thanh toán thành công.');
    }
}
