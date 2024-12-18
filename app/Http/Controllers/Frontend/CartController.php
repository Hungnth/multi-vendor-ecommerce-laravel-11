<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\ProductVariantItem;
use Illuminate\Http\Request;
use Cart;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * Show cart page
     */
    public function cartDetails()
    {
        $cartItems = Cart::content();

        if (count($cartItems) === 0) {
            Session::forget('coupon');
            flash()->flash('warning', 'Please add some products in your cart to view the cart page!', [], 'Cart is Empty!');
            return redirect()->route('home');
        }

        return view('frontend.pages.cart-detail', compact('cartItems'));
    }

    /**
     * Add item to cart
     */
    public function addToCart(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

        // Check product quantity
        if ($product->qty === 0) {
            return response()->json(['status' => 'error', 'message' => 'Product stock out!']);
        } elseif ($product->qty < $request->qty) {
            return response()->json(['status' => 'error', 'message' => 'Quantity not available in out stock!']);
        }

        $variants = [];
        $variantTotalAmount = 0;

        if ($request->has('variants_items')) {
            foreach ($request->variants_items as $item_id) {
                $variantItem = ProductVariantItem::findOrFail($item_id);
                $variants[$variantItem->productVariant->name]['name'] = $variantItem->name;
                $variants[$variantItem->productVariant->name]['price'] = $variantItem->price;
                $variantTotalAmount += $variantItem->price;
            }
        }

        // Check discount
        $productPrice = 0;
        if (checkDiscount($product)) {
            $productPrice = $product->offer_price;
        } else {
            $productPrice = $product->price;
        }

        $cartData = [];
        $cartData['id'] = $product->id;
        $cartData['name'] = $product->name;
        $cartData['qty'] = $request->qty;
        $cartData['price'] = $productPrice;
        $cartData['weight'] = 10;
        $cartData['options']['variants'] = $variants;
        $cartData['options']['variants_total'] = $variantTotalAmount;
        $cartData['options']['image'] = $product->thumb_image;
        $cartData['options']['slug'] = $product->slug;

        Cart::add($cartData);

        return response()->json(['status' => 'success', 'message' => 'Product added to cart successfully!']);
    }

    /**
     * Update product quantity
     */
    public function updateProductQty(Request $request)
    {
        $productId = Cart::get($request->rowId)->id;
        $product = Product::findOrFail($productId);
        // dd($product);

        // Check product quantity
        if ($product->qty === 0) {
            return response()->json(['status' => 'error', 'message' => 'Product stock out!']);
        } elseif ($product->qty < $request->quantity) {
            return response()->json(['status' => 'error', 'message' => 'Quantity not available in out stock!']);
        }

        Cart::update($request->rowId, $request->quantity);
        $productTotal = $this->getProductTotal($request->rowId);

        return response()->json(['status' => 'success', 'message' => 'Product quantity updated successfully!', 'productTotal' => $productTotal]);
    }

    /** Get product total */
    public function getProductTotal($rowId)
    {
        $product = Cart::get($rowId);
        $total = ($product->price + $product->options->variants_total) * $product->qty;
        return $total;
    }

    /**
     * Get Cart total amount
     */
    public function cartTotal()
    {
        $total = 0;
        foreach (Cart::content() as $product) {
            $total += $this->getProductTotal($product->rowId);
        }

        return $total;
    }

    /**
     * Clear all cart product
     */
    public function clearCart()
    {
        Cart::destroy();

        return response()->json(['status' => 'success', 'message' => 'Cart has been cleared successfully!']);
    }

    /**
     * Remove Product from Cart
     */
    public function removeProduct($rowId)
    {
        Cart::remove($rowId);

        flash()->flash('success', 'Product removed successfully!', [], 'Product');

        return redirect()->back();
    }

    /**
     * Get Cart Count
     */
    public function getCartCount()
    {
        return Cart::content()->count();
    }

    /**
     * Get all Cart Products
     */
    public function getCartProducts()
    {
        return Cart::content();
    }

    /**
     * Remove product from sidebar cart
     */
    public function removeSidebarProduct(Request $request)
    {
        Cart::remove($request->rowId);

        return response()->json(['status' => 'success', 'message' => 'Product has been removed successfully!']);
    }

    /**
     * Apply Coupon
     */
    public function applyCoupon(Request $request)
    {
        if ($request->coupon_code === null) {
            return response()->json(['status' => 'error', 'message' => 'Coupon filed is required!']);
        }

        $coupon = Coupon::where(['code' => $request->coupon_code, 'status' => 1])->first();

        if ($coupon === null) {
            return response()->json(['status' => 'error', 'message' => 'Coupon not exists!']);
        } elseif ($coupon->start_date > date('Y-m-d')) {
            return response()->json(['status' => 'error', 'message' => 'Coupon not exists!']);
        } elseif ($coupon->end_date < date('Y-m-d')) {
            return response()->json(['status' => 'error', 'message' => 'Coupon is expired!']);
        } elseif ($coupon->total_used >= $coupon->quantity) {
            return response()->json(['status' => 'error', 'message' => 'You can not apply this coupon!']);
        }

        if ($coupon->discount_type === 'amount') {
            Session::put('coupon', [
                'coupon_name' => $coupon->name,
                'coupon_code' => $coupon->code,
                'discount_type' => 'amount',
                'discount' => $coupon->discount,
            ]);
        } elseif ($coupon->discount_type === 'percent') {
            Session::put('coupon', [
                'coupon_name' => $coupon->name,
                'coupon_code' => $coupon->code,
                'discount_type' => 'percent',
                'discount' => $coupon->discount,
            ]);
        }

        return response()->json(['status' => 'success', 'message' => 'Coupon applied successfully!']);
    }

    /**
     * Calculate coupon discount
     */

    public function couponCalculation()
    {
        if (Session::has('coupon')) {
            $coupon = Session::get('coupon');
            $subTotal = getCartTotal();
            if ($coupon['discount_type'] === 'amount') {
                $total = $subTotal - $coupon['discount'];
                return response()->json(['status' => 'success', 'cart_total' => $total, 'discount' => $coupon['discount']]);
            } elseif ($coupon['discount_type'] === 'percent') {
                $discount = ($subTotal * $coupon['discount'] / 100);
                $total = $subTotal - $discount;
                return response()->json(['status' => 'success', 'cart_total' => $total, 'discount' => $discount]);
            }
        } else {
            $total = getCartTotal();
            return response()->json(['status' => 'success', 'cart_total' => $total, 'discount' => 0]);
        }
    }
}
