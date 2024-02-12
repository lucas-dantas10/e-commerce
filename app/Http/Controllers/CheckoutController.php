<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Helpers\Cart;
use App\Mail\NewOrderEmail;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Stripe\StripeClient;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
        $session = Session::create([
            'line_items' => $lineItems,
            'mode' => 'payment',
            'customer_creation' => 'always',
            'success_url' => route('checkout.success', [], true) . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.failed', [], true),
        ]);

        try {

            // Create Order
            $orderData = [
                'total_price' => $totalPrice,
                'status' => OrderStatus::Unpaid,
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ];

            $order = Order::create($orderData);

            // Create Order Items
            foreach ($orderItems as $orderItem) {
                $orderItem['order_id'] = $order->id;
                OrderItem::create($orderItem);
            }

            // Create Payment
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
        } catch (Exception $err) {
            DB::rollBack();
            Log::critical(__METHOD__ . ' method does not work. ' . $err->getMessage());
            throw $err;
        }

        DB::commit();
        CartItem::where('user_id', $user->id)->delete();

        return \redirect($session->url);
    }

    public function success(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        try {
            $session_id = $request->get('session_id');
            $session = Session::retrieve($session_id);

            if (!$session) {
                return \redirect()->route('dashboard')->with('toast', 'Invalido Id da Sessão');
            }
            $payment = Payment::query()
                ->where('session_id', $session_id)
                ->whereIn('status', [PaymentStatus::Pending, PaymentStatus::Paid])
                ->first();

            if (!$payment) {
                throw new NotFoundHttpException();
            }

            if ($payment->status == PaymentStatus::Pending->value) {
                $this->updateOrderAndSession($payment);
            }

            $customer = $session->customer_details;

            return Inertia::render('Checkout/CheckoutSuccess', [
                'customer' => $customer,
            ]);
        } catch (NotFoundHttpException $err) {
            throw $err;
        } catch (Exception $err) {
            return \redirect()->route('dashboard')->with('toast', $err->getMessage());
        }
    }

    public function failed(Request $request)
    {
        // retornar a tela de failed no vue

        return Inertia::render('Checkout/CheckoutFailed');
    }

    public function checkoutOrder(Order $order, Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        $lineItems = [];
        foreach ($order->items as $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $item->product->title,
                        'images' => $item->product->image ? [$item->product->image] : []
                    ],
                    'unit_amount' => $item->unit_price * 100,
                ],
                'quantity' => $item->quantity,
            ];
        }

        $session = Session::create([
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('checkout.success', [], true) . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.failed', [], true),
        ]);

        $order->payment->session_id = $session->id;
        $order->payment->save();

        return redirect($session->url);
    }

    public function updateOrderAndSession(Payment $payment)
    {
        DB::beginTransaction();

        try {
            $payment->status = PaymentStatus::Paid->value;
            $payment->update();

            $order = $payment->order;

            $order->status = OrderStatus::Paid->value;
            $order->update();
        } catch (Exception $err) {
            DB::rollBack();
            Log::critical(__METHOD__ . ' method does not work. ' . $err->getMessage());
            throw $err;
        }
        DB::commit();

        try {
            $adminUsers = User::where('is_admin', true)->get();

            foreach ([...$adminUsers, $order->user] as $user) {
                Mail::to($user)->send(new NewOrderEmail($order, (bool)$user->is_admin));
            }
        } catch (Exception $err) {
            Log::critical('Email sending does not work. ' . $err->getMessage());
        }
    }
}
