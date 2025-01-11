<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\addcategoryRequest;
use App\Http\Requests\admin\editcategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cate = Category::orderBy('id', 'ASC')->get();
        return view('admin.category.list', compact('cate'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.category.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(addcategoryRequest $request)
    {
        Category::create($request->all());
        return redirect()->route('category.index')->with('success', 'Thêm danh mục thành công');
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
        $category = Category::findOrFail($id);
        return view('admin.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(editcategoryRequest $request,  $id)
    {
        $category = Category::findOrFail($id);
        $category->update([
            'name' => $request->name,
        ]);
        return redirect()->route('category.index')->with('success', 'Sửa danh mục thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('category.index')->with('success', 'Xóa danh mục thành công');
    }
}
