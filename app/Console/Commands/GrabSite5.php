<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\Website;
use App\Models\ScrapedLink;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\DomCrawler\Crawler;

class GrabSite5 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'grab:site5';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Capture product infromation';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $id = 5;
        $website = Website::where('id', $id)->first();
        $scrapedlinks = ScrapedLink::where('website_id', $id)->where('id','>','20871')->cursor();

        foreach ($scrapedlinks as $item) {
            $product=Product::where('links_id',$item->id)->count();
            if ($product) {
                $this->info('item exits');
            }else{
            try {
                DB::transaction(function () use ($item, $website) {
                    $response = Http::get($item->url);
                    $crawler = new Crawler($response->body());
                    // ...

                    $data = [];

                    // For the name
                    $node = $crawler->filter($website->title);
                    if ($node->count() > 0) {
                        $data['name'] = $node->text();
                    } else {
                        $this->info('No match found for name selector: ' . $website->title);
                    }

                    // For the description
                    $node=$crawler->filter($website->description); // Select the h3 element with the id 'about-product'
                    if ($node->count() > 0) {
                        $productDescription = $node->first()->text(); // Get the text within the .cat_desc element after the h3
                        $data['description'] = trim($productDescription); // Store the product description in $data['product_description']
                    } else {
                        $this->info('No match found for description selector: ' . $website->description);
                    }

                    // For the price
                    $node = $crawler->filter($website->price);
                    if ($node->count() > 0) {
                        $data['price'] = $node->text();
                    } else {
                        $this->info('No match found for price selector: ' . $website->price);
                        $data['price'] ='Nill';
                    }

                    // For the image link
                    $node = $crawler->filter($website->image);
                    if ($node->count() > 0) {
                        $data['image_link'] = $node->attr('src');

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

                        // Use Intervention Image to handle and save the image
                        $image = Image::make($response->body());

                         // Resize the image to a width of 400px while maintaining the aspect ratio
                         $image->resize(null, 400, function ($constraint) {
                            $constraint->aspectRatio();
                        });

                        Storage::disk('public')->put("products/$filename", (string) $image->encode($extension, 90));
                        $image->destroy();

                        

                        $data['image'] = "storage/products/$filename";
                    } else {
                        $this->info('No match found for image selector: ' . $website->image);
                    }

                    $data['links_id'] = $item->id;
                    $data['website_id'] = $item->website_id;

                    // Check if the product already exists in the database
                    $product = Product::firstWhere(['links_id' => $item->id, 'website_id' => $item->website_id]);

                    if ($product) {
                        // If the product exists and the price is different, update the price
                        if ($product->price != $data['price']) {
                            $product->price = $data['price'];
                            $product->save();
                            $this->info("Product price updated: Name - {$data['name']}, New Price - {$data['price']}");
                        }
                        else{
                            $this->info("Product exist price not chnaged: Name - {$data['name']}, Price - {$data['price']},  Website ID - {$data['website_id']}");
                        }
                    } else {
                        // If the product doesn't exist, create a new one
                        Product::create($data);
                        $this->info("Product added: Name - {$data['name']}, Price - {$data['price']}, Image Link - {$data['image_link']}, Links ID - {$data['links_id']}, Website ID - {$data['website_id']}");
                    }

                   
                    // Unset large variables
                    unset($crawler);
                    unset($response);
                });

                // Manual garbage collection
                gc_collect_cycles();

                sleep(0.50);
            } catch (\Throwable $th) {
                Log::error("Error scraping link {$item->url}: " . $th->getMessage() . "\n" . $th->getTraceAsString());
            }

        }
        }

        $this->info('Scraping completed.');
    }
}
