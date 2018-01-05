<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Cart;


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

    public function addToCart($details = [])
    {
        $cart = Cart::add($details);
        return $cart;
    }

    public function total()
    {
        return Cart::total();
    }

    public function getCart()
    {
        $cart = Cart::content();
        return view('frontend.shop.cart', compact('cart'));
    }

}
