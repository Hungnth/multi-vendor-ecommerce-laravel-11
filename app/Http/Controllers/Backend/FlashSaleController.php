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
        $flashSaleDate = FlashSale::first();
        $products = Product::where('is_approved', 1)->where('status', 1)->orderBy('id', 'DESC')->get();
        return $dataTable->render('admin.flash-sale.index', compact('flashSaleDate', 'products'));
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

    public function addProduct(Request $request)
    {
        $request->validate([
            'product' => ['required', 'unique:flash_sale_items,product_id'],
            'show_at_home' => ['required'],
            'status' => ['required'],
        ], [
            'product.unique' => 'The product is already added in flash sale!',
        ],
        );

        $flashSaleDate = FlashSale::first();

        $flashSaleItem = new FlashSaleItem();
        $flashSaleItem->product_id = $request->product;
        $flashSaleItem->flash_sale_id = $flashSaleDate->id;
        $flashSaleItem->show_at_home = $request->show_at_home;
        $flashSaleItem->status = $request->status;
        $flashSaleItem->save();

        flash()->flash('success', 'Product Added Successfully!', [], 'Flash Sale');

        return redirect()->back();
    }

    public function changeShowAtHomeStatus(Request $request)
    {
        $flashSaleItem = FlashSaleItem::findOrFail($request->id);
        $flashSaleItem->show_at_home = $request->status == 'true' ? 1 : 0;
        $flashSaleItem->save();

        return response(['status' => 'success', 'message' => 'Show at Home Status Changed Successfully!']);
    }

    public function changeStatus(Request $request)
    {
        $flashSaleItem = FlashSaleItem::findOrFail($request->id);
        $flashSaleItem->status = $request->status == 'true' ? 1 : 0;
        $flashSaleItem->save();

        return response(['status' => 'success', 'message' => 'Status Changed Successfully!']);
    }

    public function destroy(string $id)
    {
        $flashSaleItem = FlashSaleItem::findOrFail($id);
        $flashSaleItem->delete();

        return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
    }
}
