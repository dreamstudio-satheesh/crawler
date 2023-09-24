<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Productresource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
     /*    if (!is_null($this->website->url)) {
           $web=$this->link->url;
        }
        else{
            $web='null';
        }
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'image' => url($this->image),
            'link' => $this->link->url,
            'website' => $web,
            'created_at' => $this->created_at->format('d-m-Y'),
            'updated_at' => $this->updated_at->format('d-m-Y'), 
            ]; */
       return parent::toArray($request);
        
    }
}
