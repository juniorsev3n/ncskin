<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Frontend\Product;
use App\Models\Frontend\Category;


class ShopController extends Controller
{
    
    public function index()
    {	
    	$products = Product::where('active', TRUE)
    						->orderBy('created_at', 'desc')
    						->paginate(12);
    	$categories = Category::where('active', TRUE)
    						->orderBy('name', 'ASC')
    						->get();

    	return view('frontend.shop', compact('products','categories'));
    }
}
