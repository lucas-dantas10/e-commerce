<?php

namespace App\Services\Checkout;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Helpers\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class CheckoutService
{
    public function checkout(User $user)
    {
        if (!$this->customerHaveAddress($user)) {
            return redirect()->route('profile.edit')->with('toast', 'Por favor, adicionar endereço primeiro!');
        }
        
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        [$products, $cartItems] = Cart::getProductsAndCartItems();

        $orderItems = [];
        $lineItems = [];
        $totalPrice = 0;

        DB::beginTransaction();

        $this->verifyQuantityProducts($products, $cartItems);

        $this->createDataForStripeSession($products, $cartItems, $totalPrice, $lineItems);

        $session = Session::create([
            'line_items' => $lineItems,
            'mode' => 'payment',
            'customer_creation' => 'always',
            'success_url' => route('checkout.success', [], true) . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.failed', [], true),
        ]);

        try {
            $order = $this->createOrder($totalPrice, $user);

            $this->createOrderItem($orderItems, $order);

            $this->createPayment($order, $user, $session, $totalPrice);
            
        } catch (Exception $err) {
            DB::rollBack();
            Log::critical(__METHOD__ . ' method does not work. ' . $err->getMessage());
            throw $err;
        }

        DB::commit();
        CartItem::where('user_id', $user->id)->delete();

        return $session->url;
    }

    private function customerHaveAddress(User $user): bool
    {
        $customer = $user->customer;

        if (!$customer->billingAddresses || !$customer->shippingAddresses) {
            return false;
        }

        return true;
    }

    private function verifyQuantityProducts(Collection $products, array $cartItems)
    {
        foreach ($products as $product) {
            $quantity = $cartItems[$product->id]['quantity'];

            if ($product->quantity !== null && $product->quantity < $quantity) {
                $message = match ($product->quantity) {
                    0 => "O produto {$product->title} sem estoque",
                    1 => "O produto {$product->title} só tem 1 unidade",
                    default => "O produto {$product->title} só tem {$product->quantity} unidades",
                };

                return \redirect()->back()->with('toast', $message);
            }
        }
    }

    private function createDataForStripeSession(Collection $products, array $cartItems, &$totalPrice, &$lineItems)
    {
        foreach ($products as $product) {
            $quantity = $cartItems[$product->id]['quantity'];
            $totalPrice += $product->price * $quantity;

            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $product->title,
                        'images' => $product->image ? [$product->image] : []
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
    }

    private function createOrder(float $totalPrice, User $user): Order
    {
        $orderData = [
            'total_price' => $totalPrice,
            'status' => OrderStatus::Unpaid,
            'created_by' => $user->id,
            'updated_by' => $user->id,
        ];

        $order = Order::create($orderData);

        return $order;
    }

    private function createOrderItem(array $orderItems, Order $order): void
    {
        foreach ($orderItems as $orderItem) {
            $orderItem['order_id'] = $order->id;
            OrderItem::create($orderItem);
        }
    }

    private function createPayment(Order $order, User $user, Session $session, float $totalPrice): void
    {
        $paymentData = [
            'order_id' => $order->id,
            'amount' => $totalPrice,
            'status' => PaymentStatus::Pending,
            'type' => 'cc',
            'created_by' => $user->id,
            'updated_by' => $user->id,
            'session_id' => $session->id
        ];

        Payment::create($paymentData);
    }
}
