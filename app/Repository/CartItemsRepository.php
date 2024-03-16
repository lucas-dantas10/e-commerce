<?php

namespace App\Repository;

use App\Models\CartItem;

class CartItemsRepository extends AbstractRepository
{
    protected static $model = CartItem::class;

    public function getCartItems()
    {
        $currentUser = request()->user();

        $cartItems = CartItem::where('user_id', $currentUser->id)
            ->get()
            ->map(
                fn ($item) => ['product_id' => $item->product_id, 'quantity' => $item->quantity]
            );

        return $cartItems;
    }

    public function saveItem($data, $user)
    {
        $itemCreated = $this->create(
            ['product_id' => $data['product_id']],
            [
                'user_id' => $user->id,
                'product_id' => $data['product_id'],
                'quantity' => 1,
                'created_at' => now(),
            ]
        );

        return $itemCreated;
    }
}
