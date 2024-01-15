<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        dd($customer);
    }
}
