<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Review;

class Product extends Model
{

    protected $fillable = ['name', 'slug', 'detail', 'price', 'stock', 'discount', 'created_at', 'updated_at'];

    public function reviews(){
    	return $this->hasMany(Review::class);
    }
}