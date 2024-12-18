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

        $variantItem = new ProductVariantItem();
        $variantItem->product_variant_id = $request->variant_id;
        $variantItem->name = $request->name;
        $variantItem->price = $request->price;
        $variantItem->is_default = $request->is_default;
        $variantItem->status = $request->status;
        $variantItem->save();

        flash()->flash('success', 'Created Successfully!', [], 'Product Variant Item');

        return redirect()->route('vendor.products-variant-item.index', ['product_id' => $request->product_id, 'variant_id' => $request->variant_id]);

    }

    public function edit(string $variantItemId)
    {
        $variantItem = ProductVariantItem::findOrFail($variantItemId);
        return view('vendor.product.product-variant-item.edit', compact('variantItem'));
    }

    public function update(Request $request, string $variantItemId)
    {
        $request->validate([
            'name' => ['required', 'max:255'],
            'price' => ['required', 'integer'],
            'is_default' => ['required'],
            'status' => ['required'],
        ]);

        $variantItem = ProductVariantItem::findOrFail($variantItemId);
        $variantItem->name = $request->name;
        $variantItem->price = $request->price;
        $variantItem->is_default = $request->is_default;
        $variantItem->status = $request->status;
        $variantItem->save();

        flash()->flash('success', 'Updated Successfully!', [], 'Product Variant Item');

        return redirect()->route('vendor.products-variant-item.index', [
            'product_id' => $variantItem->productVariant->product_id,
            'variant_id' => $variantItem->product_variant_id
        ]);
    }

    public function destroy(string $variant_item_id)
    {
        $variantItem = ProductVariantItem::findOrFail($variant_item_id);
        $variantItem->delete();

        return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
    }

    public function changeStatus(Request $request)
    {
        $variantItem = ProductVariantItem::findOrFail($request->id);
        $variantItem->status = $request->status == 'true' ? 1 : 0;
        $variantItem->save();

        return response(['status' => 'success', 'message' => 'Status Changed Successfully!']);
    }
}
