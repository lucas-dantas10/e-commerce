<?php

namespace App\Helpers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;

class Cart
{
    public static function getCartItems()
    {
        $currentUser = request()->user();

        $cartItems = CartItem::where('user_id', $currentUser->id)
            ->get()
            ->map(
                fn ($item) => ['product_id' => $item->product_id, 'quantity' => $item->quantity]
            );

        return $cartItems;
    }

    public static function getProductsAndCartItems(): array|Collection
    {
        $cartItems = self::getCartItems();

        $productsIds = Arr::pluck($cartItems, 'product_id');
        $productsOfCart = Product::query()->whereIn('id', $productsIds)->get();
        $cartItems = Arr::keyBy($cartItems, 'product_id');

        return [$productsOfCart, $cartItems];
    }
}
