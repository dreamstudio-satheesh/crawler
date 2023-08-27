<?php

namespace App\Http\Controllers;

use Artisan;
use App\Models\Website;
use App\Jobs\Scrapelink;
use App\Models\Scrapedlink;
use Illuminate\Http\Request;

class ScrapedlinkController extends Controller
{
    public function scrape_products($id)
    {
         $website = Website::where('id',$id)->first();
        if ($website)  {
            Scrapelink::dispatch( ['id' => $website->id,'url' => $website->url ,'page' => $website->product_url]);
            return back();
        }

      
        // dd(Artisan::output());
    }

    public function show($id)
    {
        $scrapedlinks = Scrapedlink::where('website_id', $id)->get();
        return view('scrapedlinks', compact('scrapedlinks'));
    }
}
