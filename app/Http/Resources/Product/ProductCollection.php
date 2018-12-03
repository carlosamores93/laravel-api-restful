<?php

namespace App\Http\Resources\Product;

//use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Resources\Json\Resource;


class ProductCollection extends Resource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id, // optional
            'user_id' => $this->user_id, // optional
            'name' => $this->name,
            'total_price' => round(( 1 - $this->discount/100) * $this->price, 2),
            'rating' => $this->reviews->count() > 0 ? round($this->reviews->sum('star')/$this->reviews->count(), 2) : 'No rating yet',
            'href' => [
                'link_product' => route('products.show', $this->id)
            ]
        ];
    }
}
