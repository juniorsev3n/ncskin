<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Datatables;

class ProductController extends Controller
{
    public function index(){
    	return view('backend.product.index');
    }

    public function getData(){
    	$products = Product::select(['id','name','images','price','stock']);
        return Datatables::of($products)
            ->addColumn('action', function ($product) {
                return '
                <a href="javascript:view('.$product->id.')" class="btn btn-md btn-success"><i class="fa fa-view"></i> View</a>
                <a href="javascript:edit('.$product->id.')" class="btn btn-md btn-primary"><i class="fa fa-edit"></i> Edit</a>
                <a href="javascript:delete('.$product->id.')" class="btn btn-md btn-danger"><i class="fa fa-delete"></i> Delete</a>';
            })
            ->editColumn('images', function($product){
            	$image = explode(",", $product->images);
            	$image = str_replace(array('"','['), '', $image);
            	return '<img src="'.url($image[0]).'" width="75" />';
            })
            ->rawColumns(['images', 'action'])
            ->make(true);
    }
}
