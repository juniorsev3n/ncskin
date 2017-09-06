<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;

class LoginController extends Controller
{
    //
    public function index()
    {
    	return view('frontend.login');
    }

    public function postLogin(Request $request)
    {	
    	$this->validate($request, 
    		[
    			'username' => 'required',
    			'password' => 'required'
    		]);
    	if($request->remember == TRUE)
    	{
    		$user = \Sentinel::authenticateAndRemember($request->only(['username', 'password']));
    	}else{
    		$user = \Sentinel::authenticate($request->only(['username', 'password']));
    	}
    	if($user)
    	{
    		return view('frontend.dashboard');
    	}
    }
}
