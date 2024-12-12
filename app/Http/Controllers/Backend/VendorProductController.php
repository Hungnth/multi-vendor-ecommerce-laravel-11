<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\VendorProductDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\ProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ChildCategory;
use App\Models\Product;
use App\Models\ProductImageGallery;
use App\Models\ProductVariant;
use App\Models\SubCategory;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Str;

class VendorProductController extends Controller
{
    use ImageUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(VendorProductDataTable $dataTable)
    {
        return $dataTable->render('vendor.product.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('vendor.product.create', compact('categories', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $image_path = $this->upload_image($request, 'image', 'uploads');

        $product = new Product();

        $product->thumb_image = $image_path;
        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->vendor_id = Auth::user()->vendor->id;
        $product->category_id = $request->category;
        $product->sub_category_id = $request->sub_category;
        $product->child_category_id = $request->child_category;
        $product->brand_id = $request->brand;
        $product->qty = $request->qty;
        $product->short_description = $request->short_description;
        $product->long_description = $request->long_description;
        $product->video_link = $request->video_link;
        $product->sku = $request->sku;
        $product->price = $request->price;
        $product->offer_price = $request->offer_price;
        $product->offer_start_date = $request->offer_start_date;
        $product->offer_end_date = $request->offer_end_date;
        $product->product_type = $request->product_type;
        $product->status = $request->status;
        $product->is_approved = 0;
        $product->seo_title = $request->seo_title;
        $product->seo_description = $request->seo_description;
        $product->save();

        flash()->flash('success', 'Created Successfully!', [], 'Product');

        return redirect()->route('vendor.products.index');
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
        $product = Product::findOrFail($id);

        // Check owner
        if($product->vendor_id != Auth::user()->vendor->id){
            abort(404);
        }

        $sub_categories = SubCategory::where('category_id', $product->category_id)->get();
        $child_categories = ChildCategory::where('sub_category_id', $product->sub_category_id)->get();
        $categories = Category::all();
        $brands = Brand::all();
        return view('vendor.product.edit', compact(
            'product',
            'categories',
            'sub_categories',
            'child_categories',
            'brands',
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, string $id)
    {
        $product = Product::findOrFail($id);

        if($product->vendor_id != Auth::user()->vendor->id){
            abort(404);
        }

        $image_path = $this->update_image($request, 'image', 'uploads', $product->thumb_image);

        $product->thumb_image = $image_path ?? $product->thumb_image;
        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->vendor_id = Auth::user()->vendor->id;
        $product->category_id = $request->category;
        $product->sub_category_id = $request->sub_category;
        $product->child_category_id = $request->child_category;
        $product->brand_id = $request->brand;
        $product->qty = $request->qty;
        $product->short_description = $request->short_description;
        $product->long_description = $request->long_description;
        $product->video_link = $request->video_link;
        $product->sku = $request->sku;
        $product->price = $request->price;
        $product->offer_price = $request->offer_price;
        $product->offer_start_date = $request->offer_start_date;
        $product->offer_end_date = $request->offer_end_date;
        $product->product_type = $request->product_type;
        $product->status = $request->status;
        $product->is_approved = $product->is_approved;
        $product->seo_title = $request->seo_title;
        $product->seo_description = $request->seo_description;
        $product->save();

        flash()->flash('success', 'Updated Successfully!', [], 'Product');

        return redirect()->route('vendor.products.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);

        // Check owner
        if($product->vendor_id != Auth::user()->vendor->id){
            abort(404);
        }

        // Delete the product thumb image
        $this->delete_image($product->thumb_image);

        // Delete product images
        $gallery_images = ProductImageGallery::where('product_id', $product->id)->get();
        foreach ($gallery_images as $gallery_image) {
            $this->delete_image($gallery_image->image);
            $gallery_image->delete();
        }

        // Delete product variants if exist
        $variants = ProductVariant::where('product_id', $product->id)->get();

        foreach ($variants as $variant) {
            $variant->product_variant_items()->delete();
            $variant->delete();
        }

        $product->delete();

        return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
    }

    public function change_status(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $product->status = $request->status == 'true' ? 1 : 0;
        $product->save();

        return response(['status' => 'success', 'message' => 'Status Changed Successfully!']);
    }

    /**
     * Get all product sub categories
     */
    public function get_sub_categories(Request $request)
    {
        $sub_categories = SubCategory::where('category_id', $request->id)->get();

        return $sub_categories;
    }

    /**
     * Get all product child categories
     */
    public function get_child_categories(Request $request)
    {
        $child_categories = ChildCategory::where('sub_category_id', $request->id)->get();

        return $child_categories;
    }
}
