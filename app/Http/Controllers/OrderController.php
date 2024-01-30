<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function index()
    {
        return Inertia::render("Orders/Orders");
    }

    public function show()
    {
        return Inertia::render("Orders/OrderDetails");
    }
}
