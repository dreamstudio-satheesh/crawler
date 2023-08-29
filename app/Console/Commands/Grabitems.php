<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\Website;
use App\Models\ScrapedLink;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\DomCrawler\Crawler;

class Grabitems extends Command
{
    protected $signature = 'grab:items {id}';

    protected $description = 'Capture product infromation ';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $id = $this->argument('id');
        $website = Website::where('id',$id)->first();
        $scrapedlinks = ScrapedLink::where('website_id',$id)->get();

        foreach ($scrapedlinks as  $item) {

            try {
                $crawler = new Crawler($item->content);
                $data['name'] = $crawler->filter($website->title)->text();
                $data['description'] = $crawler->filter($website->description)->text();
                $data['price'] = $crawler->filter($website->price)->text();
                $data['image_link']=$crawler->filter($website->image)->attr('src');




                $response = Http::get($data['image_link']);

                // Get the extension either from the URL or the Content-Type header
                $extension = pathinfo(parse_url($data['image_link'], PHP_URL_PATH), PATHINFO_EXTENSION);

                // If you couldn't get it from the URL, try the header (optional)
                if (!$extension) {
                    $contentType = $response->header('Content-Type');
                    $extension = explode('/', $contentType)[1];
                }

                // Generate a unique filename with the actual extension
                $filename = uniqid() . ".$extension";
                
                Storage::disk('public')->put("products/$filename", $response->body());


                $data['image'] = "storage/products/$filename";
                $data['links_id'] = $item->id;
                $data['website_id'] = $item->website_id;
                Product::insertOrIgnore($data);

                $this->info('item added '. $data['name']);
                $this->info('item added '. $data['price']);
                $this->info('item added '. $data['image_link']);
                $this->info('item added '. $data['links_id']);
                $this->info('item added '. $data['website_id']);

            


                

                sleep(0.5);

            } catch (\Throwable $th) {

                //throw $th;
            }
            

        }
       

    }
}
