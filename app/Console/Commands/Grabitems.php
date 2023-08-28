<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\Website;
use App\Models\ScrapedLink;
use Illuminate\Console\Command;
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
                $data['image']=$crawler->filter($website->image)->attr('src');
                $data['links_id'] = $item->id;
                $data['website_id'] = $item->website_id;

                $this->info('item added '. $data['name']);
                $this->info('item added '. $data['price']);
                $this->info('item added '. $data['image']);
                $this->info('item added '. $data['links_id']);
                $this->info('item added '. $data['website_id']);

                Product::insertOrIgnore($data);

                

            } catch (\Throwable $th) {

                //throw $th;
            }
            

        }
       

    }
}
