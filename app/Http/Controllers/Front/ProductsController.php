<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductsController extends Controller
{
    public function index(){
        // show product grid with filter of products
    }

    public function show(Product $product){

        if($product->status != 'active'){
            abort(404);
        }
        return view('front.products.show' ,compact('product'));
    }
}