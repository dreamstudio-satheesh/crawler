<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded=['id'];

    public function link()
    {
        return $this->belongsTo(ScrapedLink::class, 'links_id')->select(['id','url']);
    }

    public function website()
    {
        return $this->belongsTo(Website::class,'website_id')->select(['id','url']);
    }
}
