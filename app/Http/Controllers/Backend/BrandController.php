<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\BrandDataTable;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;
use Str;

class BrandController extends Controller
{
    use ImageUploadTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(BrandDataTable $dataTable)
    {
        return $dataTable->render('admin.brand.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.brand.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        request()->validate([
            'logo' => ['required', 'image', 'max:5120'],
            'name' => ['required', 'max:255'],
            'is_featured' => ['required'],
            'status' => ['required'],
        ]);

        $logo_path = $this->upload_image($request, 'logo', 'uploads');

        $brand = new Brand();
        $brand->logo = $logo_path;
        $brand->name = $request->name;
        $brand->slug = Str::slug($request->name);
        $brand->is_featured = $request->is_featured;
        $brand->status = $request->status;
        $brand->save();

        flash()->flash('success', 'Created Successfully!', [], 'Brand');

        return redirect()->route('admin.brand.index');
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
        $brand = Brand::findOrFail($id);
        return view('admin.brand.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        request()->validate([
            'logo' => ['image', 'max:5120'],
            'name' => ['required', 'max:255'],
            'is_featured' => ['required'],
            'status' => ['required'],
        ]);

        $brand = Brand::findOrFail($id);

        $logo_path = $this->update_image($request, 'logo', 'uploads', $brand->logo);

        $brand->logo = $logo_path ?? $brand->logo;
        $brand->name = $request->name;
        $brand->slug = Str::slug($request->name);
        $brand->is_featured = $request->is_featured;
        $brand->status = $request->status;
        $brand->save();

        flash()->flash('success', 'Updated Successfully!', [], 'Brand');

        return redirect()->route('admin.brand.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $brand = Brand::findOrFail($id);
        $this->delete_image($brand->logo);
        $brand->delete();

        return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
    }

    public function change_status(Request $request)
    {
        $category = Brand::findOrFail($request->id);
        $category->status = $request->status == 'true' ? 1 : 0;
        $category->save();

        return response(['status' => 'success', 'message' => 'Status Changed Successfully!']);
    }
}
