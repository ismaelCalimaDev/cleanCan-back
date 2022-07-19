<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getProducts()
    {
        return response()->json([
           'status' => true,
           'products' => Product::all(),
        ]);
    }
    public function getProductById($id)
    {
        return response()->json([
            'status' => true,
            'products' => Product::findOrFail($id),
        ]);
    }
}
