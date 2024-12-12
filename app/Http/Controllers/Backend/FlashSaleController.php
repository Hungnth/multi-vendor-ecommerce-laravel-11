<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\FlashSaleItemDataTable;
use App\Http\Controllers\Controller;
use App\Models\FlashSale;
use App\Models\FlashSaleItem;
use App\Models\Product;
use Illuminate\Http\Request;

class FlashSaleController extends Controller
{
    public function index(FlashSaleItemDataTable $dataTable)
    {
        $flash_sale_date = FlashSale::first();
        $products = Product::where('is_approved', 1)->where('status', 1)->orderBy('id', 'DESC')->get();
        return $dataTable->render('admin.flash-sale.index', compact('flash_sale_date', 'products'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'end_date' => ['required'],
        ]);

        FlashSale::updateOrCreate(
            ['id' => 1],
            [
                'end_date' => $request->end_date,
            ],
        );

        flash()->flash('success', 'End Date Updated Successfully!', [], 'Flash Sale');

        return redirect()->back();
    }

    public function add_product(Request $request)
    {
        $request->validate([
            'product' => ['required', 'unique:flash_sale_items,product_id'],
            'show_at_home' => ['required'],
            'status' => ['required'],
        ], [
            'product.unique' => 'The product is already added in flash sale!',
        ],
        );

        $flash_sale_date = FlashSale::first();

        $flash_sale_item = new FlashSaleItem();
        $flash_sale_item->product_id = $request->product;
        $flash_sale_item->flash_sale_id = $flash_sale_date->id;
        $flash_sale_item->show_at_home = $request->show_at_home;
        $flash_sale_item->status = $request->status;
        $flash_sale_item->save();

        flash()->flash('success', 'Product Added Successfully!', [], 'Flash Sale');

        return redirect()->back();
    }

    public function change_show_at_home_status(Request $request)
    {
        $flash_sale_item = FlashSaleItem::findOrFail($request->id);
        $flash_sale_item->show_at_home = $request->status == 'true' ? 1 : 0;
        $flash_sale_item->save();

        return response(['status' => 'success', 'message' => 'Show at Home Status Changed Successfully!']);
    }

    public function change_status(Request $request)
    {
        $flash_sale_item = FlashSaleItem::findOrFail($request->id);
        $flash_sale_item->status = $request->status == 'true' ? 1 : 0;
        $flash_sale_item->save();

        return response(['status' => 'success', 'message' => 'Status Changed Successfully!']);
    }

    public function destroy(string $id)
    {
        $flash_sale_item = FlashSaleItem::findOrFail($id);
        $flash_sale_item->delete();

        return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
    }
}
