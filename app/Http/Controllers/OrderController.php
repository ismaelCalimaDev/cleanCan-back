<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function getMyOrders()
    {
        return response()->json([
            'status' => true,
            'orders' => Order::where('user_id', auth()->user()->id)->get(),
        ]);
    }
}
