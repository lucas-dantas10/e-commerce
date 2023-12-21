<?php

namespace App\Repository;

use App\Models\CartItem;

class CartItemsRepository extends AbstractRepository
{
    public function getCartItems()
    {
        $currentUser = request()->user();

        $cartItems = CartItem::where('user_id', $currentUser->id)
            ->get()
            ->map(
                fn($item) => ['product_id' => $item->product_id, 'quantity' => $item->quantity]
            );

        return $cartItems;
    }
}
