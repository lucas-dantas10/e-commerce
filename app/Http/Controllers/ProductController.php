<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductListResource;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perPage = request('per_page', 10);
        $products = Product::paginate($perPage);

        return Inertia::render('Dashboard', [
            'products' => ProductListResource::collection($products),
        ]);
    }

    public function view(Product $product)
    {
        $cartItem = CartItem::where('user_id', auth()->user()->id)
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem == null) {
            return Inertia::render('Product/ProductView', [
                'product' => $product,
            ]);
        }

        return Inertia::render('Product/ProductView', [
            'product' => $product,
            'quantity' => $cartItem->quantity,
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
