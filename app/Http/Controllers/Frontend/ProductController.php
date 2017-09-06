<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Frontend\Product;

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
    	return view('frontend.product.show', compact('product'));
    }
}
