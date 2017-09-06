@extends('layouts.master')
@section('title', 'Login | Register')
@section('content')

<section class="section-signin-page">
    <div class="container">
        <div class="sign-in-holder">
            <div class="row">
                <div class="col-xs-12 col-sm-6">
                    <form data-ajax-handler="shop:onLogin" data-validation-message="" method="post">
                        <h3>Login</h3>
                        <input name="email" class="md-input col-xs-12" for="{{ $errors->has('email') ? '' : 'danger' }}" placeholder="e-mail" value="{{ old('email') }}">
                        @if($errors->first('email'))
                        <span>{{ $errors->first('email') }}</span>
                        @endif
                        <input type="password" name="password" class="md-input col-xs-12" for="{{ $errors->has('password') ? '' : 'danger' }}" placeholder="password">
                        @if($errors->first('password'))
                        <span>{{ $errors->first('password') }}</span>
                        @endif
                        <a class=" forget-link" href="{{ url('/password-restore') }}">forgot your password?</a>
                        <button class="md-button narrow " type="submit">sign in</button>
                        <input type="hidden" name="redirect" value="{{ url('/') }}"/>
                        {{ csrf_field() }}
                    </form>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <form data-ajax-handler="shop:onSignup" data-validation-message="">
                        <h3>Register</h3>
                        
                        <input name="signup[first_name]" id="signup[first_name]" type="text" class="md-input col-xs-12" placeholder="First Name *" />

                        <input name="signup[last_name]" id="signup[last_name]" type="text" class="md-input col-xs-12"  placeholder="Last Name *"/>
                        
                        <input id="signup[email]" type="text" name="signup[email]" class="md-input col-xs-12"  placeholder="Email *"/>
                        
                        <input name="signup[password]" id="signup[password]" type="password" class="md-input col-xs-12"  placeholder="Password *"/>
                        
                        <input name="signup[password_confirmation]" id="signup[password_confirmation]" type="password" class="md-input col-xs-12"  placeholder="Confirm Password *" style="margin-bottom: 15px"/><br>

                        <input class="md-check" name="accepts_marketing" type="checkbox" id="accepts_marketing" checked/> Recieve promotional emails

                        <input type="hidden" name="autologin" value="1" />
                        <input type="hidden" name="redirect" value="{{ url('registered') }}"/>
                        <button class="md-button narrow">submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection