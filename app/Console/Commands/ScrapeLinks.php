<?php

namespace App\Console\Commands;

use App\Models\ScrapedLink;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;

class ScrapeLinks extends Command
{
    protected $signature = 'scrape:links {id} {url} {page}';
    protected $description = 'Scrape all links from a website';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $id = $this->argument('id');
        $startingUrl = $this->argument('url');
        $productsLink = $this->argument('page');
        $domain = parse_url($startingUrl, PHP_URL_HOST);

        $queue = [$startingUrl];
        $visited = [];

        while (!empty($queue)) {
            $url = array_shift($queue);

            if (!in_array($url, $visited)) {
                $response = Http::get($url);
                $crawler = new Crawler($response->body(), $url); // Pass the base URL to the constructor

                $links = $crawler->filter('a')->links();

                foreach ($links as $link) {
                    $href = $link->getUri();
                    $parsedUrl = parse_url($href);

                    if (strpos($href, $productsLink) !== false) {
                        if (!Str::contains($href, '#')) {
                            $this->storeLinks($href, $id); // Store the link in the database
                            $this->info("Links found on : $href");
                        }
                        
                    } else {
                        // $this->info("Links not found on  : $href");
                    }

                    $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg', 'pdf']; // Add more if needed

                    if (isset($parsedUrl['host']) && $parsedUrl['host'] === $domain) {
                        if (!isset($parsedUrl['scheme'])) {
                            // Handle relative URLs by constructing an absolute URL
                            $href = $url . (isset($parsedUrl['path']) ? $parsedUrl['path'] : '') . (isset($parsedUrl['query']) ? '?' . $parsedUrl['query'] : '');
                        }

                        if (isset($parsedUrl['path'])) {
                            // Check if the URL extension is in the imageExtensions array
                            $urlExtension = pathinfo($parsedUrl['path'], PATHINFO_EXTENSION);
                            //&& Str::contains($parsedUrl['path'], 'category')  && Str::contains($href, 'collections')
                            if (!in_array(strtolower($urlExtension), $imageExtensions)  && !Str::contains($href, '#') && Str::contains($href, '/product-category/') && !Str::contains($href, '/product/') && !Str::contains($href, '?') ) {
                                if (!in_array($href, $queue)) {
                                    $queue[] = $href;
                                    $this->info("Links queued on  $href");
                                }
                            }
                        }
                    }
                }
                if (!in_array($url, $visited)) {
                    $visited[] = $url;
                }
            } else {
                // $this->info(" visted : $url");
            }
            sleep(0.25);
        }

        $this->info('Scraping completed.');
    }

    private function storeLinks($url, $id, $content = null)
    {
        if (ScrapedLink::where('url', $url)->exists()) {
            // $this->info(" Record exists on  db : $url");
        } else {

            try {

                ScrapedLink::insert([
                    'website_id' => $id,
                    'url' => $url,
                    'content' => '',
                ]);

            } catch (\Throwable $th) {
                //throw $th;
            }
          
        }
    }
}
