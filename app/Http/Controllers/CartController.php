<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use App\Services\Cart\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Number;
use Inertia\Inertia;

class CartController extends Controller
{

    public function __construct(
        protected CartService $cartService,
    )
    { }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        [$cartItems, $products, $total] = $this->cartService->getCartItemsWithProducts();

        return Inertia::render('Cart/Cart', [
            'cartItems' => $cartItems,
            'products' => $products,
            'total' => $total
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
    public function store(Request $request): RedirectResponse
    {
        $user = $request->user();
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|numeric'
        ]); 

        $dataValidated = $validator->validated();

        $itemCreated = $this->cartService->saveItemInCart($dataValidated, $user);

        if ($itemCreated->wasRecentlyCreated) {
            return \redirect()->back()->with('toast', 'Item adicionado no carrinho!');
        }   

        return \redirect()->back()->with('toast', 'Item já está no carrinho');
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
    public function update(Request $request, string $productId)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|numeric',
            'quantity' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return;
        }

        $dataValidated = $validator->validated();

        $this->cartService->updateQuantityOfCart($productId, $dataValidated);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $productId)
    {
        $productOfCart = CartItem::where('product_id', $productId)
            ->where('user_id', auth()->user()->id)->delete();

        return;
    }
}
