<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\addcarRequest;
use App\Http\Requests\admin\editcarRequest;
use App\Models\Address;
use App\Models\Brand;
use App\Models\Car;
use App\Models\CarImage;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Throwable;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->role == 'admin') {
            $cars = Car::all();
        } else {
            $user = Auth::id();
            $cars = Car::where('user_id', $user)->get();
        }
        return view('admin.car.list', compact('cars'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $brands = Brand::all();
        $categories = Category::all();
        return view('admin.car.add', compact('brands', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(addcarRequest $request)
    {
        try {
            $address = Address::create([
                'province' => $request->input('province'),
                'district' => $request->input('district'),
                'ward' => $request->input('ward'),
                'street' => $request->input('street'),
            ]);
            $user_id = Auth::id();
            $main_image = $request->file('main_image');
            $name_main_image = time() . '_' . $main_image->getClientOriginalName();
            $main_image->storeAs('public/img_car', $name_main_image);


            // except bỏ qua ảnh
            $cardata = $request->except('main_image', 'secondary_image');
            $cardata['main_image'] = $name_main_image;
            $cardata['user_id'] = $user_id;
            $cardata['address_id'] = $address->id;
            $car = Car::create($cardata);
            //lưu ảnh phụ
            if ($request->HasFile('secondary_image')) {
                foreach ($request->file('secondary_image') as  $secondary_image) {
                    $name_secondary_image = time() . '_' . $secondary_image->getClientOriginalName();
                    $secondary_image->storeAs('public/img_car', $name_secondary_image);
                    CarImage::create([
                        'car_id' => $car->id,
                        'image' => $name_secondary_image
                    ]);
                }
            }

            return redirect()->route('car.index')->with('success', 'Thêm mới thành công');
        } catch (Throwable $th) {
            return redirect()->back()->with('error', 'Thêm mới thất bại: ' . $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $car = Car::findOrFail($id);
        $brands = Brand::all();
        $categories = Category::all();
        $address = Address::find($car->address_id);
        return view('admin.car.edit', compact('car', 'brands', 'categories', 'address'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(editcarRequest $request, string $id)
    {

        $car = Car::findOrFail($id);
        $address = Address::find($car->address_id);
        $address->update([
            'province' => $request->input('province'),
            'district' => $request->input('district'),
            'ward' => $request->input('ward'),
            'street' => $request->input('street'),
        ]);

        $car->name = $request->input('name');
        if ($request->hasFile('main_image')) {
            if ($car->main_image) {
                Storage::delete('public/img_car/' . $car->main_image);
            }
            $main_image = $request->file('main_image');
            $name_main_image = time() . '_' . $main_image->getClientOriginalName();
            $main_image->storeAs('public/img_car', $name_main_image);
            $car->main_image = $name_main_image;
        }

        if ($request->hasFile('secondary_image')) {
            // Thêm ảnh phụ mới
            foreach ($request->file('secondary_image') as $secondary_image) {
                $name_secondary_image = time() . '_' . $secondary_image->getClientOriginalName();
                $secondary_image->storeAs('public/img_car', $name_secondary_image);
                CarImage::create([
                    'car_id' => $car->id,
                    'image' => $name_secondary_image
                ]);
            }
        }

        // Cập nhật các trường còn lại
        $car->user_id = Auth::id();
        $car->price = $request->input('price');
        $car->discounted_price = $request->input('discounted_price');
        $car->license_plate = $request->input('license_plate');
        $car->manufacture_year = $request->input('manufacture_year');
        $car->fuel_type = $request->input('fuel_type');
        $car->color = $request->input('color');
        $car->transmission = $request->input('transmission');
        $car->status = $request->input('status');
        $car->description = $request->input('description');
        $car->brand_id = $request->input('brand_id');
        $car->category_id = $request->input('category_id');

        // Lưu cập nhật
        $car->save();

        // Trả về thông báo thành công và chuyển hướng
        return redirect()->route('car.index')->with('success', 'Cập nhật xe thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $car = Car::findOrFail($id);
            if ($car->status === 'Đang thuê') {
                return redirect()->route('car.index')->with('error', 'Bạn không thể xóa xe này vì xe đang được thuê.');
            }
            if ($car->main_image && Storage::exists('public/img_car/' . $car->main_image)) {
                Storage::delete('public/img_car/' . $car->main_image);
            }
            foreach ($car->images as $image) {
                if (Storage::exists('public/img_car/' . $image->image)) {
                    Storage::delete('public/img_car/' . $image->image);
                }
                $image->delete();
            }
            $car->delete();
            return redirect()->route('car.index')->with('success', 'Xóa xe thành công!');
        } catch (Throwable $th) {
            return redirect()->back()->with('error', 'Xóa xe thất bại: ' . $th->getMessage());
        }
    }
    public function destroyimage($id)
    {
        try {
            $image = CarImage::findOrFail($id);
            if (Storage::exists('public/img_car/' . $image->image)) {
                Storage::delete('public/img_car/' . $image->image);
            }
            $image->delete();
            return redirect()->route('car.edit', $image->car_id)->with('success', 'Ảnh đã được xóa thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi xóa ảnh: ' . $e->getMessage());
        }
    }
    public function editStatus($id)
    {
        $car = Car::findOrFail($id);
        return view('admin.car.edit-status', compact('car'));
    }

    public function updateStatus(Request $request, $id)
    {
        $car = Car::findOrFail($id);
        $request->validate([
            'status' => 'required|string',
        ]);

        $car->status = $request->status;
        $car->save();
        return redirect()->route('car.index')->with('success', 'Cập nhật tình trạng xe thành công');
    }
}
