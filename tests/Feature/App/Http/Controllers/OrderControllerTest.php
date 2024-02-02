<?php

use Inertia\Testing\AssertableInertia;

uses()->group('orders');

it('return from the orders page has the orders property', function () {
    $response = $this->get('/orders');

    $response->assertInertia(fn (AssertableInertia $page) => $page
        ->component('Orders/Orders')
        ->has('orders')
    );
    $response->assertStatus(200);
});
