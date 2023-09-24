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
        $searchQuery = $request->input('query');
        $per_page=20;
        if($request->has('per_page'))  $per_page=$request->per_page;

        if ($searchQuery) {
            $products = Product::where('name', 'LIKE', "%{$searchQuery}%")->paginate($per_page);
            
            $message = $products ? 'data fetched' : 'No record found';  
            return $this->sendResponse(Productresource::collection($products), $message);

        //return response()->json($products);
        }

        
    }
}
