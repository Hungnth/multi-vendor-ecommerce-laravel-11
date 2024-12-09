<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\ChildCategoryDataTable;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ChildCategory;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Str;

class ChildCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ChildCategoryDataTable $dataTable)
    {
        return $dataTable->render('admin.child-category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.child-category.create', compact('categories'));
    }

    /**
     * Get sub categories
     */
    public function get_sub_categories(Request $request)
    {
        $sub_categories = SubCategory::where('category_id', $request->id)->where('status', 1)->get();
        return $sub_categories;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category' => ['required'],
            'sub_category' => ['required'],
            'name' => ['required', 'max:200', 'unique:child_categories,name'],
            'status' => ['required'],
        ]);

        $child_category = new ChildCategory();
        $child_category->category_id = $request->category;
        $child_category->sub_category_id = $request->sub_category;
        $child_category->name = $request->name;
        $child_category->slug = Str::slug($request->name);
        $child_category->status = $request->status;
        $child_category->save();

        flash()->flash('success', 'Created Successfully!', [], 'Child Category');

        return redirect()->route('admin.child-category.index');
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
    public function edit(string $id)
    {
        $categories = Category::all();
        $child_category = ChildCategory::findOrFail($id);
        $sub_categories = SubCategory::where('category_id', $child_category->category->id)->get();

        return view('admin.child-category.edit', compact('categories', 'sub_categories', 'child_category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'category' => ['required'],
            'sub_category' => ['required'],
            'name' => ['required', 'max:200', 'unique:child_categories,name,'.$id],
            'status' => ['required'],
        ]);

        $child_category = ChildCategory::findOrfail($id);

        $child_category->category_id = $request->category;
        $child_category->sub_category_id = $request->sub_category;
        $child_category->name = $request->name;
        $child_category->slug = Str::slug($request->name);
        $child_category->status = $request->status;
        $child_category->save();

        flash()->flash('success', 'Update Successfully!', [], 'Child Category');

        return redirect()->route('admin.child-category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $child_category = ChildCategory::findOrfail($id);
        $child_category->delete();

        return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
    }

    public function change_status(Request $request)
    {
        $category = ChildCategory::findOrFail($request->id);
        $category->status = $request->status == 'true' ? 1 : 0;
        $category->save();

        return response(['status' => 'success','message' => 'Status Changed Successfully!']);
    }


}
