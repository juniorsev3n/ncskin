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

    public function getAdd(Request $request)
    {
        try{
            $product = Product::find($request->id);
            if($product->stock >= 1){
                Cart::add($product->id, $product->name, $request->qty, $product->price);
                return redirect()->back()->with('status', 'Item telah ditambahkan ke keranjang');
            }
            return redirect()->back()->with('error','Item tidak ditemukan');
        }catch(\Exception $e){
            \Log::info($e->getMessage());
            return redirect()->back()->with('error','Item gagal ditambahkan ke keranjang');
        }
    }

    public function getTotal()
    {
        return Cart::total();
    }

    public function getContent()
    {
        $cart = Cart::content();
        $total = $this->getTotal();
        //dd($cart);
        return view('frontend.shop.cart', compact('cart','total'));
    }

    public function getRemove($RowId)
    {
        return Cart::remove($RowId);
    }

    public function getDestroy()
    {
        return Cart::destroy();
    }

}
