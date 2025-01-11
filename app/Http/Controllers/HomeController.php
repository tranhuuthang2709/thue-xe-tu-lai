<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Car;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $brands = Brand::withCount('cars')->orderByDesc('cars_count')->take(6)->get();
        $cars = Car::take(6)->get();
        $newcar = Car::orderByDesc('created_at')->take(6)->get();
        $topcars = Car::withCount('bookingsdetail')->orderByDesc('bookingsdetail_count')->take(6)->get();
        return view('user.home', compact('brands', 'cars', 'newcar', 'topcars'));
    }
    public function detail($id)
    {

        $car_detail = Car::where('id', $id)->first();
        $related_cars = Car::where('category_id', $car_detail->category_id)
            ->where('id', '!=', $car_detail->id)  // Loại bỏ xe hiện tại
            ->take(3)->get();
        $comments = Comment::where('car_id', $id)->orderBy('created_at', 'desc')->get();
        return view('user.detail', compact('car_detail', 'related_cars', 'comments'));
    }
    public function favorite($id)
    {
        $user_id = Auth::id();
        $favotired = Favorite::where(['user_id' => $user_id, 'car_id' => $id])->first();

        if ($favotired) {
            $favotired->delete();
            return redirect()->back()->with('success', 'Bỏ thích sản phẩm thành công');
        } else {
            $data = [
                'user_id' => $user_id,
                'car_id' => $id
            ];
            Favorite::create($data);
            return redirect()->back()->with('success', 'Yêu thích sản phẩm thành công');
        }
    }
    public function favoriteCars()
    {
        $user = Auth::id();
        $favorite = Favorite::where('user_id', $user)->with('car')->paginate(5);
        return view('user.list-favorite-cars', compact('favorite'));
    }
}
