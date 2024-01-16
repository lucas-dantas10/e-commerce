<?php

namespace App\Http\Controllers;

use App\Helpers\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        $user = $request->user();
        $customer = $user->customer;
        if (!$customer->billingAddresses || !$customer->shippingAddresses) {
            return redirect()->route('profile.edit')->with('toast', 'Por favor, adicionar endereço primeiro!');
        }
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        [$products, $cartItems] = Cart::getProductsAndCartItems();

        $orderItems = [];
        $lineItems = [];
        $totalPrice = 0;

        DB::beginTransaction();

        foreach ($products as $product) {
            $quantity = $cartItems[$product->id]->quantity;

            if ($product->quantity !== null && $product->quantity < $quantity) {
                $message = match ($product->quantity) {
                    0 => "O produto {$product->title} sem estoque",
                    1 => "O produto {$product->title} só tem 1 unidade",
                    default => "O produto {$product->title} só tem {$product->quantity} unidades",
                };
            }

            return \redirect()->back()->with('toast', $message);
        }

        foreach ($products as $product) {
            $quantity = $cartItems[$product->id]->quantity;
            $totalPrice += $product->price * $quantity;

            $lineItems[] = [
                'price_data' => [
                    'currency' => 'brl',
                    'product_data' => [
                        'name' => $product->title,
                        'images' => $product->image,
                    ],
                    'unit_amount' => $product->price * 100,
                ],
                'quantity' => $quantity,
            ];

            $orderItems[] = [
                'product_id' => $product->id,
                'quantity' => $quantity,
                'unit_price' => $product->price,
            ];

            if ($product->quantity !== null) {
                $product->quantity -= $quantity;
                $product->save();
            }
        
        }

        $session = Session::create([
            'line_items' => $lineItems,
            'mode' => 'payment',
            'customer_creation' => 'always',
            'success_url' => route('checkout.success'),
            'cancel_url' => route('checkout.cancel'),
        ]);

        \dd($session);
    }
}
