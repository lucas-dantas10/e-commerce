<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderItemResource;
use App\Http\Resources\OrderResource;
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
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->get();

        $orderFormated = OrderItemResource::collection($orders);

        return Inertia::render('Orders/Orders', [
            'orders' => $orderFormated,
        ]);
    }

    public function show(Order $order)
    {
        $user = request()->user();

        if ($order->created_by !== $user->id) {
            return \redirect()->back()->with('toast', 'Você não tem permissão para realizar esta ação!');
        }

        $orderItems = $order->items()->with('product')->get();

        return Inertia::render('Orders/OrderShow', [
            'order' => new OrderResource($order),
            'orderItems' => $orderItems,
        ]);
    }
}
