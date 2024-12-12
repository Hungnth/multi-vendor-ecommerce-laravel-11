<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\VendorProductVariantItemDataTable;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductVariantItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorProductVariantItemController extends Controller
{
    public function index(VendorProductVariantItemDataTable $dataTable, $product_id, $variant_id)
    {
        $product = Product::findOrFail($product_id);
        $variant = ProductVariant::findOrFail($variant_id);

        return $dataTable->render('vendor.product.product-variant-item.index', compact('product', 'variant'));
    }

    public function create(string $product_id, string $variant_id)
    {
        $product = Product::findOrFail($product_id);
        $variant = ProductVariant::findOrFail($variant_id);

        return view('vendor.product.product-variant-item.create', compact('variant', 'product'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => ['required', 'integer'],
            'variant_id' => ['required', 'integer'],
            'name' => ['required', 'max:255'],
            'price' => ['required', 'integer'],
            'is_default' => ['required'],
            'status' => ['required'],
        ]);

        $variant_item = new ProductVariantItem();
        $variant_item->product_variant_id = $request->variant_id;
        $variant_item->name = $request->name;
        $variant_item->price = $request->price;
        $variant_item->is_default = $request->is_default;
        $variant_item->status = $request->status;
        $variant_item->save();

        flash()->flash('success', 'Created Successfully!', [], 'Product Variant Item');

        return redirect()->route('vendor.products-variant-item.index', ['product_id' => $request->product_id, 'variant_id' => $request->variant_id]);

    }

    public function edit(string $variant_item_id)
    {
        $variant_item = ProductVariantItem::findOrFail($variant_item_id);
        return view('vendor.product.product-variant-item.edit', compact('variant_item'));
    }

    public function update(Request $request, string $variant_item_id)
    {
        $request->validate([
            'name' => ['required', 'max:255'],
            'price' => ['required', 'integer'],
            'is_default' => ['required'],
            'status' => ['required'],
        ]);

        $variant_item = ProductVariantItem::findOrFail($variant_item_id);
        $variant_item->name = $request->name;
        $variant_item->price = $request->price;
        $variant_item->is_default = $request->is_default;
        $variant_item->status = $request->status;
        $variant_item->save();

        flash()->flash('success', 'Updated Successfully!', [], 'Product Variant Item');

        return redirect()->route('vendor.products-variant-item.index', [
            'product_id' => $variant_item->product_variant->product_id,
            'variant_id' => $variant_item->product_variant_id
        ]);
    }

    public function destroy(string $variant_item_id)
    {
        $variant_item = ProductVariantItem::findOrFail($variant_item_id);
        $variant_item->delete();

        return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
    }

    public function change_status(Request $request)
    {
        $variant_item = ProductVariantItem::findOrFail($request->id);
        $variant_item->status = $request->status == 'true' ? 1 : 0;
        $variant_item->save();

        return response(['status' => 'success', 'message' => 'Status Changed Successfully!']);
    }
}
