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
        $per_page=5;
        if($request->has('per_page'))  $per_page=$request->per_page;

        if ($query) {
           

            // perform search using Eloquent
            $products = Product::where('name', 'LIKE', "%{$query}%")
                            ->orWhere('description', 'LIKE', "%{$query}%")
                            ->paginate($per_page);
            
            
            return response()->json(Productresource::collection($products), 200);
        }

        
    }
}
