<?php

namespace App\Http\Controllers;


use App\Jobs\Grabitems;
use App\Models\Product;
use App\Models\Website;
use App\Models\ScrapedLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function list(Request $request)
    {
        $id = $request->id;
        if ($id) {
            $scrapedlinks = ScrapedLink::where('website_id', $id)->get();
            
            //check links already collected else redirect to product links page
            if ($scrapedlinks->count()) {

                //check products is not empty
                if (Product::where('website_id', $id)->count()) {

                    $products=Product::where('website_id', $id)->get();
                    return view('productlist', compact('products'));
                   
                } else {
                    Grabitems::dispatch(['id' => $id]);
                    return back();
                }

                $website = Website::where('id', $id)->first();
            } else {
                return redirect('product_links/' . $id);
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
