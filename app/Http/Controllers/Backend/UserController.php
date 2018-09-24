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
    	$user = User::select(['id', 'first_name', 'email', 'is_admin']);
        return Datatables::of($user)
            ->addColumn('action', function ($user) {
                return '
                <a href="javascript:view('.$user->id.')" class="btn btn-md btn-success"><i class="fa fa-view"></i> View</a>
                <a href="javascript:edit('.$user->id.')" class="btn btn-md btn-primary"><i class="fa fa-edit"></i> Edit</a>
                <a href="javascript:delete('.$user->id.')" class="btn btn-md btn-danger"><i class="fa fa-delete"></i> Delete</a>';
            })
            ->editColumn('is_admin', function($user){
            	if($user->is_admin == 1){
            		return 'admin';
            	}else{
            		return 'user';
            	}
            })
            ->make(true);
    }
}
