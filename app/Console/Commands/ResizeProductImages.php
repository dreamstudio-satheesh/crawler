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

            $this->info(" image  path: {$imagePath}");

            if (file_exists($imagePath)) {


                // $fileSize = filesize($imagePath);

                // Get the pathinfo of the file
                $pathinfo = pathinfo($product->image);

                // Get the filename without the extension
                $filename = basename($product->image, '.' . $pathinfo['extension']);

                

                $img = Image::make($imagePath)->resize(300, 300, function ($constraint) {
                    $constraint->aspectRatio();
                })->encode('png', 90);

                $img->save(public_path('storage/products/' . $filename . '.png'));


                //update product image
                Product::where('id', $product->id)
                    ->update(['image' => 'storage/products/' . $filename . '.png']);
            

                $this->info("Resized image for product ID: {$filename} {$product->id} ");


                $img->destroy(); 

                // If the file size is greater than 500 KB
                /*  if ($fileSize > (500 * 1024)) {
                    $image = Image::make($imagePath);

                    $image->resize(null, 400, function ($constraint) {
                        $constraint->aspectRatio();
                    });

                    $image->save($imagePath, 90); // Save with 90% quality
                    $image->destroy();
                } */

                
                


            } else {
                $this->error("Image not found for product ID: {$product->id}");
            }
        }

        $this->info('All product images have been resized!');
    }
}
