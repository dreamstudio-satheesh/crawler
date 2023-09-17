<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Models\Product;

class ResizeProductImages extends Command
{
    protected $signature = 'product:resize-images';
    protected $description = 'Resize product images to 300px width';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $products = Product::whereNotNull('image')->get();

        foreach ($products as $product) {
            $imagePath = public_path($product->image);

            if (file_exists($imagePath)) {
                $image = Image::make($imagePath);

                $image->resize(400, 400, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                $image->save($imagePath, 90);  // Save with 90% quality

                $this->info("Resized image for product ID: {$product->id}");
            } else {
                $this->error("Image not found for product ID: {$product->id}");
            }
        }

        $this->info('All product images have been resized!');
    }
}
