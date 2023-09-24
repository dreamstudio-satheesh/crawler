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
       // $this->middleware('ip.check');
    }

    public function search(Request $request)
    {
        $query = $request->input('query'); // getting the user input from query parameter
        $per_page=20;
        if($request->has('per_page'))  $per_page=$request->per_page;

        if ($query) {
           

            // perform search using Eloquent
            $products = Product::where('name', 'LIKE', "%{$query}%")
                            ->orWhere('description', 'LIKE', "%{$query}%")
                            ->with(['link'])
                            ->paginate($per_page);

            return response()->json([
                'data' => ProductResource::collection($products->items()),
                'pagination' => [
                    'current_page' => $products->currentPage(),
                    'last_page' => $products->lastPage(),
                    'per_page' => $products->perPage(),
                    'total' => $products->total(),
                ]
            ], 200);
            
            //return ProductResource::collection($products)->response()->getData(true);
            // return response()->json(Productresource::collection($products), 200);
        }

        
    }
}
