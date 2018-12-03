<?php

namespace App\Http\Controllers;

use App\Exceptions\ProductNotBelongsToUser;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\Product\ProductCollection;
use App\Http\Resources\Product\ProductResource;
use App\Model\Product;
use Illuminate\Http\Request;
use Auth;
use Symfony\Component\HttpFoundation\Response as ResponseHttp;

// Tambine funciona asi, renombrar donde está ResponseHttp -> Response
//use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{


    public function __construct(){
        $this->middleware('auth:api')->except('index', 'show');
        //$this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return ProductResource::collection(Product::all());
        return ProductCollection::collection(Product::paginate(5));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        /*
        $product = new Product();
        $product->name = $request->name;
        $product->slug = str_slug($request->name);
        $product->detail = $request->description;
        $product->stock = $request->stock;
        $product->price = $request->price;
        $product->discount = $request->discount;
        $product->save();
        */


        $product = Product::create([
            'name' => $request->name,
            'slug' => str_slug($request->name),
            'detail' => $request->description,
            'stock' =>  $request->stock,
            'price' =>  $request->price,
            'discount' =>  $request->discount,
        ]);

        return response([
            'data' => new ProductResource($product)
        ], ResponseHttp::HTTP_CREATED);
        // vendor/symfony/http-foundation/Response.php
        // HTTP_CREATED

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {

        $this->ProductUserCheck($product);
        if(isset($request['name'])){
            $request['slug'] = str_slug($request->name);
        }else if(isset($request['description'])){
            $request['detail'] = $request->description;
            unset($request['description']);
        } 
        $product->update($request->all());
        return response([
            'data' => new ProductResource($product)
        ], ResponseHttp::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //return $product;
        $product->delete();
        return response(null, ResponseHttp::HTTP_NO_CONTENT);
        //return response(['data' => 'Producto borrado'], ResponseHttp::HTTP_NO_CONTENT);
    }


    // php artisan make:exception ProductNotBelongsToUser
    // php artisan passport:install Token postam
    public function ProductUserCheck($product){
        if (Auth::id() !== $product->user_id) {
            throw new ProductNotBelongsToUser;
        }
    }
}
