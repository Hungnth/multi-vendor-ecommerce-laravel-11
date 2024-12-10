<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\ProductImageGalleryDataTable;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImageGallery;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;

class ProductImageGalleryController extends Controller
{
    use ImageUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, ProductImageGalleryDataTable $dataTable)
    {

        $product = Product::findOrFail($request->product);
        return $dataTable->render('admin.product.image-gallery.index', compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
           'image.*' => ['required', 'image', 'max:5120'],
        ]);

        // Handle images upload
        $image_paths = $this->upload_multi_image($request, 'image', 'uploads');

        foreach ($image_paths as $image_path) {
            $product_image_gallery = new ProductImageGallery();
            $product_image_gallery->image = $image_path;
            $product_image_gallery->product_id = $request->product;
            $product_image_gallery->save();
        }

        flash()->flash('success', 'Uploaded Successfully!', [], 'Product Image Gallery');

        return redirect()->back();
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product_image = ProductImageGallery::findOrFail($id);
        $this->delete_image($product_image->image);
        $product_image->delete();

        return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
    }
}
