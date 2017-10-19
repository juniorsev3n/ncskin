<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Frontend\Product;
use App\Models\Frontend\Review;

class ProductController extends Controller
{
    public function index()
    {
    	return redirect('shop');
    }
    public function show($slug)
    {
    	$product = Product::where('slug', $slug)
    					   ->where('active', true)
    					   ->first();

        $reviews = Review::where('product_id', $product->id)
                         ->get();

        $related = Product::where('category_id', $product->category_id)
                            ->where('active', true)
                            ->take(1)
                            ->get();
    	return view('frontend.product.show', compact('product', 'reviews', 'related'));
    }
}
