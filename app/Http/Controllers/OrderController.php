<?php

namespace App\Http\Controllers;

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
            
        return Inertia::render("Orders/Orders", [
            'orders' => $orders,
        ]);
    }

    public function show()
    {
        return Inertia::render("Orders/OrderDetails");
    }
}
