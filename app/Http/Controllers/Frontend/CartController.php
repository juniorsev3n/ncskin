<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\RegionCategory;
use App\Models\Shipping;
use Cart;
use Illuminate\Http\Request;
use Redirect;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cart = Cart::content();
        \Session::put('price',Cart::total());
        \Session::put('totalPrice',Cart::total());
        \Session::put('paycode',0);

        return view('frontend.shop.cart', compact('cart'));
    }

    public function cart(Request $req)
    {
		$explode = explode(',', $req->vals);

		for($i = 0; $i < count($explode); $i++){

			Cart::add([
				'id'    => $req->kms[$explode[$i]],
				'name'  => $req->name,
				'price' => $req->price[$explode[$i]],
				'qty'   => $req->qty[$explode[$i]],
				'options' => array(
					'product_id'        => $req->id,
					'image'             => $req->image,
					'stok'              => $req->stok[$explode[$i]],
					)
				]);
		}

		\Session::put('price', Cart::total());
		\Session::put('totalPrice', Cart::total());
		\Session::put('count_cart', Cart::count(false));

		return redirect('cart');
	}

	public function update(Request $req)
	{
		$totalWeight = 0;
		for ($i=0; $i < count($req->kemasan); $i++) {

			$qty = $req->qty[$i];
			$kemasan = $req->kemasan[$i];

			$totalWeight += $qty * $kemasan;

			Cart::update($req->rowid[$i],[
			'qty' => $req->qty[$i]
			]);
		}

		\Session::put('price',Cart::total());
		\Session::put('totalPrice',Cart::total());

		return redirect('otentifikasi');

	}

	public function destroy($id)
	{
		Cart::remove($id);
		\Session::put('count_cart',Cart::count(false));
		\Session::put('price',Cart::total());
		\Session::put('totalPrice', Cart::total());
		\Session::put('grandTotalPrice', Cart::total());

		return redirect()->back();
	}

}

