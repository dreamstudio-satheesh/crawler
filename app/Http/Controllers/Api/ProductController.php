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
        //  $this->middleware('ip.check');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $keywords = $request->input('keywords');
        $per_page = $request->input('per_page', 20);
        $keywordArray = !empty($keywords) ? array_map('trim', explode(',', $keywords)) : [];

        $products = Product::query();

        if ($query) {
            $products->where('name', 'RLIKE', '\\b' . $query . '\\b')->orWhere('description', 'RLIKE', '\\b' . $query . '\\b');
        }

        if (!empty($keywordArray)) {
            $products->where(function ($q) use ($keywordArray) {
                foreach ($keywordArray as $keyword) {
                    $q->orWhere('name', 'RLIKE', '\\b' . $keyword . '\\b')->orWhere('description', 'RLIKE', '\\b' . $keyword . '\\b');
                }
            });
        }

        // If you want to shuffle results only when no specific query is given, you can conditionally apply inRandomOrder()
        if (empty($query) && empty($keywords)) {
            $products->inRandomOrder();
        }

        // Remove or comment out the following line if you're using inRandomOrder() as it conflicts with specific ordering
        // if ($query) {
        //     $products->orderByRaw('CASE WHEN name = ? THEN 1 ELSE 2 END, name', [$query]);
        // }

        $products = $products->with(['link', 'website'])->paginate($per_page);

        return response()->json(
            [
                'data' => ProductResource::collection($products->items()),
                'pagination' => [
                    'current_page' => $products->currentPage(),
                    'last_page' => $products->lastPage(),
                    'per_page' => $products->perPage(),
                    'total' => $products->total(),
                ],
            ],
            200,
        );
    }

    /* public function search(Request $request)
    {
        $query = $request->input('query');
        $keywords = $request->input('keywords');
        $per_page = 20;

        if ($request->has('per_page')) {
            $per_page = $request->per_page;
        }
        $keywordArray = [];

        if ($keywords) {
            $keywordArray = strpos($keywords, ',') !== false ? explode(',', $keywords) : [$keywords];
        }
        $products = Product::query();

        if ($query) {
            $products->where('name', 'LIKE', "%{$query}%");
        }

        if (!empty($keywordArray)) {
            $products->orWhere(function ($q) use ($keywordArray) {
                foreach ($keywordArray as $keyword) {
                    $q->orWhere('name', 'LIKE', "%{$keyword}%");
                   // $q->orWhere('description', 'LIKE', "%{$keyword}%");
                }
            });
        }
        // Prioritize rows that have exact match with $query
        if ($query) {
            $products->orderByRaw('CASE WHEN name = ? THEN 1 ELSE 2 END, name', [$query]);
        }

        $products = $products->with(['link', 'website'])->paginate($per_page);

        return response()->json(
            [
                'data' => ProductResource::collection($products->items()),
                'pagination' => [
                    'current_page' => $products->currentPage(),
                    'last_page' => $products->lastPage(),
                    'per_page' => $products->perPage(),
                    'total' => $products->total(),
                ],
            ],
            200,
        );
    } */
}
