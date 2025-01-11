<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Booking_detail;
use App\Models\Car;
use App\Models\Refund;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Admin_HomeController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        if ($user->role === 'admin' || $user->role === 'employee') {
            $totalCars = Car::count();
            $totalUsers = User::count();
            $totalBookings = Booking::count();
            $totalRefund = Booking::where('status', 'Đã hủy')->count();

            // Đếm trạng thái đặt
            $bookingStatusCounts = Booking_detail::selectRaw('pickup_status, COUNT(*) as count')
                ->groupBy('pickup_status')
                ->pluck('count', 'pickup_status')->toArray();

            $query = Booking::where('status', 'Thành công');
            //theo thời gian
            if ($startDate && $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }
            $monthlyRevenue = $query
                ->selectRaw('SUM(total_amount) as revenue, MONTH(created_at) as month')
                ->groupBy('month')
                ->orderBy('month')
                ->pluck('revenue', 'month');
        } else if ($user->role === 'lessor') {
            $totalCars = Car::where('user_id', $user->id)->count();
            $totalUsers = User::where('id', $user->id)->count();
            $totalBookings = Booking::where('user_id', $user->id)->count();
            $totalRefund = Booking::where('status', 'Đã hủy')->where('user_id', $user->id)->count();

            $carIds = Car::where('user_id', $user->id)->pluck('id')->toArray();

            $bookingStatusCounts = Booking_detail::whereHas('booking', function ($query) use ($user, $carIds) {
                $query->whereIn('car_id', $carIds);
            })
                ->selectRaw('pickup_status, COUNT(*) as count')
                ->groupBy('pickup_status')
                ->pluck('count', 'pickup_status')->toArray();

            $query = Booking::where('status', 'Thành công')->where('user_id', $user->id);
            if ($startDate && $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }

            $monthlyRevenue = $query
                ->selectRaw('SUM(total_amount) as revenue, MONTH(created_at) as month')
                ->groupBy('month')
                ->orderBy('month')
                ->pluck('revenue', 'month');
        }

        $monthlyRevenueData = array_fill(1, 12, 0);
        foreach ($monthlyRevenue as $month => $revenue) {
            $monthlyRevenueData[$month] = (float) $revenue;
        }

        return view('admin.home', compact(
            'totalCars',
            'totalUsers',
            'totalBookings',
            'totalRefund',
            'monthlyRevenueData',
            'bookingStatusCounts'
        ));
    }
}
