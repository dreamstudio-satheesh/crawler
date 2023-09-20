<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('ip.check');
    }

    public function search(Request $request)
    {
        $searchQuery = $request->input('query');

        $products = Product::where('name', 'LIKE', "%{$searchQuery}%")->get();

        return response()->json($products);
    }
}
