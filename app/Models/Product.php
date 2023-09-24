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
        return $this->hasOne(ScrapedLink::class, 'links_id');
    }
}
