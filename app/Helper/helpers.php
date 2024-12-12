<?php

/**
 * Set Sidebar item active
 */
function set_active(array $route)
{
    if (is_array($route)) {
        foreach ($route as $r) {
            if (request()->routeIs($r)) {
                return 'active';
            }
        }
    }
}

// Check product have discount
function check_discount($product): bool
{
    $current_date = date('Y-m-d');

    if ($product->offer_price > 0 && $current_date >= $product->offer_start_date && $current_date <= $product->offer_end_date) {
        return true;
    }
    return false;
}

// Calculate discount percent
function calculate_discount_percent($original_price, $discount_price)
{
    $discount_amount = $original_price - $discount_price;
    $discount_percent = round(($discount_amount / $original_price) * 100);

    return $discount_percent;
}

// Check the product type
function product_type(string $type): string
{
    return match ($type) {
        'new_arrival' => 'New',
        'featured_product' => 'Featured',
        'top_product' => 'Top',
        'best_product' => 'Best',
        default => '',
    };
}
