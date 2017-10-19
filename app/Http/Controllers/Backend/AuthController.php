<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Sentinel;
use Validator;

class AuthController extends Controller
{
    public function index(){
    	return view('backend.login');
    }

    public function postLogin(Request $request){
		$rules = array(
            'email' => 'required|email',
            'password' => 'required|min:3');

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect('admin/login')
                            ->withErrors($validator) // send back all errors to the login form
                            ->withInput($request->except('password'));
        } else {
            $credentials = array(
                'email' => $request->get('email'),
                'password' => $request->get('password')
            );
            if ($request->get('remember_me') == '1') {
                    $user = Sentinel::authenticateAndRemember($credentials);
            } else {
                    $user = Sentinel::authenticate($credentials);
            }
            if ($user && $user->is_admin == 1) {

                    return redirect()->intended('admin/dashboard');
            }
        }
        return redirect('admin/login')->withErrors('Email atau Password salah');
    }
}
