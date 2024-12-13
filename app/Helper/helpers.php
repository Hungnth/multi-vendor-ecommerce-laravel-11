<?php

/**
 * Set Sidebar item active
 */
function setActive(array $route)
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
function checkDiscount($product): bool
{
    $currentDate = date('Y-m-d');

    if ($product->offer_price > 0 && $currentDate >= $product->offer_start_date && $currentDate <= $product->offer_end_date) {
        return true;
    }
    return false;
}

// Calculate discount percent
function calculateDiscountPercent($original_price, $discount_price): float
{
    $discountAmount = $original_price - $discount_price;
    $discountPercent = round(($discountAmount / $original_price) * 100);

    return $discountPercent;
}

// Check the product type
function productType(string $type): string
{
    return match ($type) {
        'new_arrival' => 'New',
        'featured_product' => 'Featured',
        'top_product' => 'Top',
        'best_product' => 'Best',
        default => '',
    };
}
