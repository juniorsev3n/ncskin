@extends('layouts.default')

@section('title', 'Checkout')

@section('content')

<div class="container">
    <div class="row">
        <div class="sign-in-holder">
            <div class="content">
                <div class="col-sm-6">
                    <h3 id="title-p">Returning Customers</h3>
                    <form data-ajax-handler="shop:onLogin" data-validation-message="" class="form-horizontal">

                    <div class="form-group">
                        <div class="col-sm-9">
                            <input type="email" class="form-control input-sm" id="login_email" placeholder="email address" name="email" value="{{ old('email') }}" size="40" autofocus />
                            <span class="error small text-danger"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-9">
                            <input type="password" class="form-control input-sm" placeholder="password" id="login_password" name="password" size="20" />
                            <span class="error small text-danger"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-9">
                            <button type="submit" class="btn btn-sm btn-important">Login</button>
                            <a class="btn btn-sm btn-link forgotpass" href="{{ url('password-restore') }}">Forgot your password?</a>
                        </div>
                    </div>
                    
                    <input type="hidden" name="redirect" value="{{ url('/checkout') }}"/>
          
                </form>
                </div>
                <div class="col-xs-12 col-sm-4">
                    <form class="form-guest-checkout">
                        <h3 id="title-p">Guest Checkout</h3>
                        <br>
                        <a href="{{ url('checkout') }}"><span class="btn btn-sm btn-important">Continue as a Guest</span></a>
                        <a class="btn btn-sm btn-link forgotpass" href="{{ url('login') }}"> Register</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection