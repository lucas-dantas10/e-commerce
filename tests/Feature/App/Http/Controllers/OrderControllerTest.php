<?php

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
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

    $response->assertInertia(fn (AssertableInertia $page) => $page
        ->component('Orders/Orders')
        ->has('orders', 1)
    );
    $response->assertStatus(200);
});

it('checks if the subtotal is correct', function () {
    $response = $this->get('/orders');

    $product = Product::factory()->create();

    $order = Order::create([
        'total_price' => $product->price,
        'status' => 'pago',
        'created_by' => auth()->id(),
        'created_at' => now()
    ]);

    $orderItem = OrderItem::create([
        'product_id' => $product->id,
        'order_id' => $order->id,
        'quantity' =>  1,
        'unit_price' => $product->price,
        'created_at' => now()
    ]);

    expect($product->price)->toBe($orderItem->unit_price);
    $response->assertStatus(200);
});
