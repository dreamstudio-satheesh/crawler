<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Productresource;
use App\Http\Controllers\Api\BaseController;

class ProductController extends BaseController
{
    public function __construct()
    {
        //$this->middleware('ip.check');
    }

    public function search(Request $request)
{
    $query = $request->input('query');
    $keywords = $request->input('keywords');
    $per_page = 20;

    if ($request->has('per_page')) {
        $per_page = $request->per_page;
    }

    $keywordArray = [];

    if ($keywords && strpos($keywords, ',') !== false) {
        $keywordArray = explode(',', $keywords);
    }

    $products = Product::query();

    if ($query) {
        //$products->where('name', 'LIKE', "%{$query}%");
        $products->where('name', $query);
    }

    if (!empty($keywordArray)) {
        $products->where(function ($q) use ($keywordArray) {
            foreach ($keywordArray as $keyword) {
                $q->orWhere('name', 'LIKE', "%{$keyword}%");
                $q->orWhere('description', 'LIKE', "%{$keyword}%");
            }
        });
    }

    $products = $products->with(['link', 'website'])->paginate($per_page);

    return response()->json([
        'data' => ProductResource::collection($products->items()),
        'pagination' => [
            'current_page' => $products->currentPage(),
            'last_page' => $products->lastPage(),
            'per_page' => $products->perPage(),
            'total' => $products->total(),
        ]
    ], 200);
}

}
