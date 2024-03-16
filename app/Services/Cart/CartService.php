<?php

namespace App\Services\Cart;

use App\Models\CartItem;
use App\Models\Product;
use App\Repository\CartItemsRepository;
use Illuminate\Support\Arr;
use Illuminate\Support\Number;

class CartService
{
    public function __construct(
        protected CartItemsRepository $cartRepository,
    ) {
    }

    public function getCartItemsWithProducts()
    {
        $cartItems = $this->cartRepository->getCartItems();

        $productsIds = Arr::pluck($cartItems, 'product_id');
        $productsOfCart = Product::query()->whereIn('id', $productsIds)->get();
        $cartItems = Arr::keyBy($cartItems, 'product_id');

        $total = 0;
        foreach ($productsOfCart as $product) {
            $total += $product->price * $cartItems[$product->id]['quantity'];
        }
        $totalFormated = str_replace('R$', 'R$ ', Number::currency($total, 'BRL'));

        return [
            $cartItems,
            $productsOfCart,
            $totalFormated,
        ];
    }

    public function updateQuantityOfCart($productId, $dataValidated)
    {
        $cartItem = CartItem::where('product_id', $productId)
            ->where('user_id', auth()->user()->id);

        $updated = $cartItem->update(['quantity' => $dataValidated['quantity']]);

        if ($updated) {
            return \redirect()->back();
        }

    }

    public function saveItemInCart($dataValidated, $user)
    {
        $itemCreated = $this->cartRepository->saveItem($dataValidated, $user);

        return $itemCreated;
    }
}
