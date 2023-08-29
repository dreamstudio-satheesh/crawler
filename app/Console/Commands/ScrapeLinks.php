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
                    $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg']; // Add more if needed

                    if (isset($parsedUrl['host']) && $parsedUrl['host'] === $domain) {
                        if (!isset($parsedUrl['scheme'])) {
                            // Handle relative URLs by constructing an absolute URL
                            $href = $url . (isset($parsedUrl['path']) ? $parsedUrl['path'] : '') . (isset($parsedUrl['query']) ? '?' . $parsedUrl['query'] : '');
                        }

                        // Check if the URL extension is in the imageExtensions array
                        $urlExtension = pathinfo($parsedUrl['path'], PATHINFO_EXTENSION);
                        if (!in_array(strtolower($urlExtension), $imageExtensions) && !Str::contains($parsedUrl['path'], '#')) {
                            $queue[] = $href;
                        }
                    }
                }

                $visited[] = $url;

                if (strpos($url, $productsLink) !== false) {
                    $this->storeLinks($url, $id, $response->body()); // Store the link in the database

                    $this->info("Links found on $startingUrl: $url");
                } else {
                    $this->info("Links not found on $startingUrl : $url");
                }

            }
            sleep(0.5);
        }

        $this->info('Scraping completed.');
    }

    private function storeLinks($url, $id, $content = null)
    {
        ScrapedLink::insertOrIgnore([
            'website_id' => $id,
            'url' => $url,
            'content' => $content,
        ]);
    }
}
