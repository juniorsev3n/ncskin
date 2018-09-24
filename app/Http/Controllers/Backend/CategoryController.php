<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Datatables;

class CategoryController extends Controller
{
    public function index()
    {
    	return view('backend.category.index');
    }

    public function getData()
    {
    	$categories = Category::select(['id','name','images','description','active']);
        return Datatables::eloquent($categories)
            ->addColumn('action', function ($categories) {
                return '
                <a href="javascript:view('.$categories->id.')" class="btn btn-md btn-success"><i class="fa fa-view"></i> View</a>
                <a href="javascript:edit('.$categories->id.')" class="btn btn-md btn-primary"><i class="fa fa-edit"></i> Edit</a>
                <a href="javascript:delete('.$categories->id.')" class="btn btn-md btn-danger"><i class="fa fa-delete"></i> Delete</a>';
            })
            ->editColumn('images', function($categories){
            	$image = explode(",", $categories->images);
            	$image = str_replace(array('"','['), '', $image);
            	return url($image[0]);
            })
            ->make(true);
    }
}