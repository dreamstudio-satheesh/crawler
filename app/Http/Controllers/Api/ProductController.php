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
        if ($searchQuery) {
            $totalRecords = Product::where('name', 'LIKE', "%{$searchQuery}%")->count();
            $skip = isset($request->page) ? $request->page : 0;

            $products = Product::where('name', 'LIKE', "%{$searchQuery}%")
            ->offset($skip)
            ->limit(10)
            ->get();

            $balalceRecords = $totalRecords - ($skip + 10);
            $nextpage ='false';
            if ($balalceRecords > 0) {
                $nextpage = 'true';
            }

            $message = $products ? 'data fetched' : 'No record found';  
            return $this->sendResponse(Productresource::collection($products), $message,$nextpage);

        //return response()->json($products);
        }

        
    }
}
