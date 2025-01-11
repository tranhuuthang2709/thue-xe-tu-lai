<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\addbrandRequest;
use App\Http\Requests\admin\editbrandRequest;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brand = Brand::orderBy('id', 'ASC')->get();
        return view('admin.brand.list', compact('brand'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.brand.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(addbrandRequest $request)
    {
        $image = $request->file('image');
        $image = time() . '_' . $image->getClientOriginalName();
        $request->image->storeAs('public/img_brand', $image);
        $data = [
            'name' => $request->name,
            'image' => $image
        ];
        Brand::create($data);
        return redirect()->route('brand.index')->with('success', 'Thêm danh mục thành công');
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
        $brand = Brand::findOrFail($id);
        return view('admin.brand.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(editbrandRequest $request, $id)
    {
        $brand = Brand::findOrFail($id);
        $image = $brand->image;

        if ($request->hasFile('image')) {
            $newImage = $request->file('image');
            $imageName = time() . '_' . $newImage->getClientOriginalName();

            $oldImagePath = public_path('storage/img_brand') . '/' . $brand->image;
            if (file_exists($oldImagePath) && $brand->image) {
                unlink($oldImagePath);
            }
            $request->image->storeAs('public/img_brand', $imageName);
            $image = $imageName;
        }

        // Cập nhật dữ liệu
        $brand->update([
            'name' => $request->name,
            'image' => $image,
        ]);

        return redirect()->route('brand.index')->with('success', 'Sửa thương hiệu thành công');
    }
    public function destroy(string $id)
    {
        $brand = Brand::findOrFail($id);
        $image =  public_path('storage/img_brand') . '/' . $brand->image;
        if (file_exists($image) && $brand->image) {
            unlink($image);
        }
        $brand->delete();
        return redirect()->route('brand.index')->with('success', 'Xóa danh mục thành công');
    }
}
