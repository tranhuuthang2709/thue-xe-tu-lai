<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Car;
use App\Models\Category;
use Illuminate\Http\Request;

use function Laravel\Prompts\search;

class ListCarController extends Controller
{
    /**
     * Xử lý tìm kiếm xe theo các tiêu chí.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function search(Request $request)
    {
        $search = $request->input('search');
        $minPrice = $request->input('min_price', 0);
        $maxPrice = $request->input('max_price', 5000000);
        $brands = $request->input('brand', []);
        $province = $request->input('province1_value');
        $seat = $request->input('seat');
        $categories = $request->input('category', []);
        $pickup_time = $request->input('pickup_date');
        $return_time = $request->input('return_date');


        $query = Car::query();

        if ($search) {
            $searchTermNoAccent = $this->removeAccents($search);
            $query->where('name', 'like', '%' . $searchTermNoAccent . '%');
        }
        if ($minPrice || $maxPrice) {
            $query->whereBetween('price', [$minPrice, $maxPrice]);
        }
        if ($brands && count($brands) > 0) {
            $query->whereIn('brand_id', $brands);
        }
        if ($categories && count($categories) > 0) {
            $query->whereIn('category_id', $categories);
        }
        if ($seat) {
            $query->where('seat', $seat);
        }
        if ($province) {
            $query->whereHas('address', function ($q) use ($province) {
                $q->where('province', $province);
            });
        }
        if ($pickup_time && $return_time) {
            $query->whereDoesntHave('bookingsdetail', function ($q) use ($pickup_time, $return_time) {
                $q->where(function ($query) use ($pickup_time, $return_time) {
                    $query->whereHas('pickupAddress', function ($query) use ($pickup_time, $return_time) {
                        $query->whereDate('pickup_time', '<=', $return_time)
                            ->whereDate('pickup_time', '>=', $pickup_time);
                    })
                        ->orWhereHas('returnAddress', function ($query) use ($pickup_time, $return_time) {
                            $query->whereDate('return_time', '<=', $return_time)
                                ->whereDate('return_time', '>=', $pickup_time);
                        });
                });
            });
        }

        $cars = $query->paginate(5);
        $brands = Brand::all();
        $categories = Category::all();

        return view('user.list_car', compact('cars', 'brands', 'categories'));
    }
    private function removeAccents($string)
    {
        $accentedChars = [
            'á',
            'à',
            'ả',
            'ã',
            'ạ',
            'ă',
            'ắ',
            'ằ',
            'ẳ',
            'ẵ',
            'ặ',
            'â',
            'ấ',
            'ầ',
            'ẩ',
            'ẫ',
            'ậ',
            'é',
            'è',
            'ẻ',
            'ẽ',
            'ẹ',
            'ê',
            'ế',
            'ề',
            'ể',
            'ễ',
            'ệ',
            'í',
            'ì',
            'ỉ',
            'ĩ',
            'ị',
            'ó',
            'ò',
            'ỏ',
            'õ',
            'ọ',
            'ô',
            'ố',
            'ồ',
            'ổ',
            'ỗ',
            'ộ',
            'ơ',
            'ớ',
            'ờ',
            'ở',
            'ỡ',
            'ợ',
            'ú',
            'ù',
            'ủ',
            'ũ',
            'ụ',
            'ư',
            'ứ',
            'ừ',
            'ử',
            'ữ',
            'ự',
            'đ',
            'Đ'
        ];

        $unaccentedChars = [
            'a',
            'a',
            'a',
            'a',
            'a',
            'a',
            'a',
            'a',
            'a',
            'a',
            'a',
            'a',
            'a',
            'a',
            'a',
            'a',
            'a',
            'a',
            'e',
            'e',
            'e',
            'e',
            'e',
            'e',
            'e',
            'e',
            'e',
            'e',
            'e',
            'e',
            'i',
            'i',
            'i',
            'i',
            'i',
            'o',
            'o',
            'o',
            'o',
            'o',
            'o',
            'o',
            'o',
            'o',
            'o',
            'o',
            'o',
            'o',
            'o',
            'o',
            'o',
            'o',
            'o',
            'u',
            'u',
            'u',
            'u',
            'u',
            'u',
            'u',
            'u',
            'u',
            'u',
            'u',
            'u',
            'd',
            'D'
        ];

        return str_replace($accentedChars, $unaccentedChars, $string);
    }
    public function index()
    {
        $brands = Brand::all();
        $categories = Category::all();
        $cars = Car::paginate(5);

        return view('user.list_car', compact('cars', 'brands', 'categories'));
    }
}
