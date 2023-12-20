<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Inertia\Inertia;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currentUser = request()->user();
        $cartItems = CartItem::where('user_id', $currentUser->id)
            ->get()
            ->map(
                fn($item) => ['product_id' => $item->product_id, 'quantity' => $item->quantity]
            );

        $productsIds = Arr::pluck($cartItems, 'product_id');

        $productsOfCart = Product::query()->whereIn('id', $productsIds)->get();

        $cartItems = Arr::keyBy($productsOfCart, 'product_id');

        // \dd([$productsOfCart, $cartItems]);

        return Inertia::render('Cart/Cart', [
            'cartItems' => $cartItems,
            'products' => $productsOfCart,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
