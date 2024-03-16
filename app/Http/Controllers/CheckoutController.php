<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Events\NewOrderCreatedEvent;
use App\Models\Order;
use App\Models\Payment;
use App\Services\Checkout\CheckoutService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CheckoutController extends Controller
{
    public function __construct(
        protected CheckoutService $checkoutService
    ) {
    }

    public function checkout(Request $request)
    {
        $user = $request->user();

        $sessionUrl = $this->checkoutService->checkout($user);

        return redirect($sessionUrl);
    }

    public function success(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        try {
            $session_id = $request->get('session_id');
            $session = Session::retrieve($session_id);

            if (! $session) {
                return \redirect()->route('dashboard')->with('toast', 'Invalido Id da Sessão');
            }
            $payment = Payment::query()
                ->where('session_id', $session_id)
                ->whereIn('status', [PaymentStatus::Pending, PaymentStatus::Paid])
                ->first();

            if (! $payment) {
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
                        'images' => $item->product->image ? [$item->product->image] : [],
                    ],
                    'unit_amount' => $item->unit_price * 100,
                ],
                'quantity' => $item->quantity,
            ];
        }

        $session = Session::create([
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('checkout.success', [], true).'?session_id={CHECKOUT_SESSION_ID}',
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
            Log::critical(__METHOD__.' method does not work. '.$err->getMessage());
            throw $err;
        }
        DB::commit();

        try {
            event(new NewOrderCreatedEvent($order));
        } catch (Exception $err) {
            Log::critical('Email sending does not work. '.$err->getMessage());
        }
    }
}
