<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Datatables;

class UserController extends Controller
{
    public function index(){
    	return view('backend.user.index');
    }

    public function getData(){
    	$users = User::selectRaw("id, concat(first_name,' ',last_name) as name, email, is_admin as status");
        return Datatables::of($users)
            ->addColumn('action', function ($users) {
                return '
                <a href="javascript:view('.$users->id.')" class="btn btn-md btn-success"><i class="fa fa-view"></i> View</a>
                <a href="javascript:edit('.$users->id.')" class="btn btn-md btn-primary"><i class="fa fa-edit"></i> Edit</a>
                <a href="javascript:delete('.$users->id.')" class="btn btn-md btn-danger"><i class="fa fa-delete"></i> Delete</a>';
            })
            ->editColumn('status', function($users){
            	if($users->status == 1){
            		return 'admin';
            	}else{
            		return 'user';
            	}
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
