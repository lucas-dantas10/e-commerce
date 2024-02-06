<?php

use App\Models\Order;
use Inertia\Testing\AssertableInertia;

uses()->group('orders');

it('page orders has the orders property', function () {
    $response = $this->get('/orders');

    $response->assertInertia(fn (AssertableInertia $page) => $page
        ->component('Orders/Orders')
        ->has('orders')
    );
    $response->assertStatus(200);
});

it('number of orders from the logged in user is correct', function () {
    $response = $this->get('/orders');

    $orders = Order::query()
            ->where('created_by', auth()->id())
            ->count();

    $response->assertInertia(fn (AssertableInertia $page) => $page
        ->component('Orders/Orders')
        ->has('orders', $orders)
    );
    $response->assertStatus(200);
});

// it('checks if the subtotal is correct', function () {
//     $response = $this->get('/orders');

//     $orders = Order::query()
//             ->where('created_by', auth()->id())
//             ->count();
//     dd($orders);
// });
