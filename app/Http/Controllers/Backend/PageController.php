<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Page;

class PageController extends Controller
{
    public function index(){
    	return view('backend.page.index');
    }

    public function getData(){
    	$page = Page::select(['id','name','images','price','stock']);
        return Datatables::eloquent($page)
            ->addColumn('action', function ($page) {
                return '
                <a href="javascript:view('.$page->id.')" class="btn btn-md btn-success"><i class="fa fa-view"></i> View</a>
                <a href="javascript:edit('.$page->id.')" class="btn btn-md btn-primary"><i class="fa fa-edit"></i> Edit</a>
                <a href="javascript:delete('.$page->id.')" class="btn btn-md btn-danger"><i class="fa fa-delete"></i> Delete</a>';
            })
            ->editColumn('images', function($page){
            	$image = explode(",", $page->images);
            	$image = str_replace(array('"','['), '', $image);
            	return url($image[0]);
            })
            ->editColumn('price', function($page){
                return number_format($page->price, 0, ',', '.');
            })
            ->make();
    }

    public function getAdd(){
        return view('backend.page.add');
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
            $page = new page;
            $page->name = $request->name;
            $page->slug = str_slug($request->name);
            $page->description = $request->description;
            $pruduct->optional = json_encode($request->optional);
            $page->images = json_encode($request->images);
            $page->price = (int) $request->price;
            if(isset($request->discount)){
                $page->is_discount = 1;
                $page->discount = $request->discount;
            }
            $page->is_homepage = $request->is_homepage;
            $page->category_id = $request->category_id;
            $page->brand_id = $request->brand_id;
            $page->user_id = \Sentinel::getUser()->id;
            $page->active = $request->active;
            $page->stock = $request->stock;
            $page->save();

            $messages = 'Add page Success';
        }catch(\Exception $e){
            $message = 'Add page Failed';
        }

        return response()->json(['message' => $message]);
    }

    public function addImage(Request $request){
        $this->validate($request->all(), [
            'image' => 'required|image']
            );

        $pathTmp = public_path() . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'page' . DIRECTORY_SEPARATOR;
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
            $page = page::findOrFail($id);
            $page->delete();
            $message = 'page telah dihapus';
        }catch(\Exception $e){
            DB::rollBack();
            $message = 'page gagal dihapus';
        }
        return response()->json(['message' => $message]);
    }

    public function show($id){
        $page = page::find($id);
        if($page){
            return response()->json($page);
        }
        return response()->json(['message' => 'page tidak ditemukan']);
    }
}
