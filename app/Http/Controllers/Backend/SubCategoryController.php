<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\SubCategoryDataTable;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ChildCategory;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Str;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SubCategoryDataTable $dataTable)
    {
        return $dataTable->render('admin.sub-category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.sub-category.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category' => ['required'],
            'name' => ['required', 'max:200', 'unique:sub_categories,name'],
            'status' => ['required'],
        ]);

        $sub_category = new SubCategory();
        $sub_category->category_id = $request->category;
        $sub_category->name = $request->name;
        $sub_category->slug = Str::slug($request->name);
        $sub_category->status = $request->status;
        $sub_category->save();

        flash()->flash('success', 'Created Successfully!', [], 'Sub Category');

        return redirect()->route('admin.sub-category.index');
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
        $sub_category = SubCategory::findOrFail($id);
        return view('admin.sub-category.edit', compact('sub_category', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'category' => ['required'],
            'name' => ['required', 'max:200', 'unique:sub_categories,name,' . $id],
            'status' => ['required'],
        ]);

        $sub_category = SubCategory::findOrFail($id);

        $sub_category->category_id = $request->category;
        $sub_category->name = $request->name;
        $sub_category->slug = Str::slug($request->name);
        $sub_category->status = $request->status;
        $sub_category->save();

        flash()->flash('success', 'Updated Successfully!', [], 'Sub Category');

        return redirect()->route('admin.sub-category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sub_category = SubCategory::findOrFail($id);

        $child_category = ChildCategory::where('sub_category_id', $sub_category->id)->count();
        if ($child_category > 0) {
            return response(['status' => 'error', 'message' => 'This items contains sub items for delete this you have to delete the sub items first!']);
        }

        $sub_category->delete();
        return response()->json(['status' => 'success', 'message' => 'Deleted Successfully']);
    }

    public function change_status(Request $request)
    {
        $sub_category = SubCategory::findOrFail($request->id);
        $sub_category->status = $request->status == 'true' ? 1 : 0;
        $sub_category->save();

        return response(['message' => 'Status Changed Successfully!']);
    }
}
