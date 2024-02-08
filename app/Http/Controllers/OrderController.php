<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderItemResource;
use App\Http\Resources\OrderItems;
use App\Models\Order;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $orders = Order::query()
            ->where('created_by', $user->id)
            ->get();

       $orderFormated = OrderItemResource::collection($orders);

        return Inertia::render("Orders/Orders", [
            'orders' => $orderFormated,
        ]);
    }

    public function show()
    {
        return Inertia::render("Orders/OrderDetails");
    }
}
