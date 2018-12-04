<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Product;

class Review extends Model
{

	protected $fillable = ['product_id', 'customer', 'slug', 'review', 'star'];


    public function product(){
    	return $this->belongsTo(Product::class);
    }
}
