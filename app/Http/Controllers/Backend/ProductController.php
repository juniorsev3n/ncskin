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
        return Datatables::eloquent($products)
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
            ->make();
    }

    public function getAdd(){
        return view('backend.product.add');
    }

    public function postAdd(Request $request){
        $this->validate($request->all(),[
            'name' => 'required|min:3',
            'description' => 'required|min:3',
            'optional' => 'required',
            'images' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required',
            'brand_id' => 'required',
            'stock' => 'required|numeric',
            ]);

        try {
            DB::beginTransaction();
            $product = new Product;
            $product->name = $request->name;
            $product->slug = str_slug($request->name);
            $product->description = $request->description;
            $pruduct->optional = json_encode($request->optional);
            $product->images = json_encode($request->images);
            $product->price = (int) $request->price;
            if(isset($request->discount)){
                $product->is_discount = 1;
                $product->discount = $request->discount;
            }
            $product->is_homepage = $request->is_homepage;
            $product->category_id = $request->category_id;
            $product->brand_id = $request->brand_id;
            $product->user_id = \Sentinel::getUser()->id;
            $product->active = $request->active;
            $product->stock = $request->stock;
            $product->save();

            $messages = 'Add Product Success';
        }catch(\Exception $e){
            $message = 'Add Product Failed';
        }

        return response()->json(['message' => $message]);
    }

    public function addImage(Request $request){
        $this->validate($request->all(), [
            'image' => 'required|image']
            );

        $pathTmp = public_path() . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'products' . DIRECTORY_SEPARATOR;
        $message = array();
        if(is_array($request->image)){
            foreach($request->image as $key => $img){              
                $file = $img;
                $ext = $file->getClientOriginalExtension();
                $filename = $file->getClientOriginalName();
                $new_filename = md5(time() . $filename) . '.' . $ext;
                $uploadSuccess = $request->file('image')->move($pathTmp, $new_filename);
                $message[$key] = 'Upload image #'.$key.'success';
            }

        }else{
                $file = $request->file('image');
                $ext = $file->getClientOriginalExtension();
                $filename = $file->getClientOriginalName();
                $new_filename = md5(time() . $filename) . '.' . $ext;
                $uploadSuccess = $request->file('image')->move($pathTmp, $new_filename);
                if (file_exists($uploadSuccess)){
                    $message[0] = 'Upload image #0 success';
                }
        }

        return response()->json(['message' => $message]);
    }

    public function getRemove($id){
        try{
            DB::beginTransaction();
            $product = Product::findOrFail($id);
            $product->delete();
            $message = 'Product telah dihapus';
        }catch(\Exception $e){
            DB::rollBack();
            $message = 'Product gagal dihapus';
        }
        return response()->json(['message' => $message]);
    }

    public function show($id){
        $product = Product::find($id);
        if($product){
            return response()->json($product);
        }
        return response()->json(['message' => 'Product tidak ditemukan']);
    }
}
