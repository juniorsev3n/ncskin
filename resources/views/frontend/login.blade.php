@extends('layouts.master')
@section('title', 'Login | Register')
@section('content')

<section class="section-signin-page">
    <div class="container">
        <div class="sign-in-holder">
            <div class="row">
                <div class="col-xs-12 col-sm-6">
                    @if(!empty(session('error')))
                        <div class="alert-danger">{{ session('error') }}</div>
                    @endif
                    <form action="{{ url('login') }}" method="post">
                        <h3>Login</h3>
                        <input name="email" class="md-input col-xs-12" placeholder="e-mail" value="{{ old('email') }}">
                        @if($errors->first('email'))
                        <span class="alert-danger">{{ $errors->first('email') }}</span>
                        @endif
                        <input type="password" name="password" class="md-input col-xs-12" placeholder="password">
                        @if($errors->first('password'))
                        <span class="alert-danger">{{ $errors->first('password') }}</span><br>
                        @endif
                        <a class="forget-link" href="{{ url('/password-reset') }}">forgot your password?</a>
                        <button class="md-button narrow " type="submit">sign in</button>
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-xs-12" align="center"><a href="{{ url('/login/facebook') }}"><img src="{{ url('images/icon/facebook.png')}}" width="250"></a></div>
                            <div class="col-xs-12" align="center"><a href="{{ url('/login/google') }}"><img src="{{ url('images/icon/google.png')}}" width="250"></a></div>
                        </div>
                    </form>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <form action="{{ url('register') }}" method="post">
                        <h3>Register</h3>

                        <input name="firstname" type="text" class="md-input col-xs-12" placeholder="First Name *" />

                        <input name="lastname" type="text" class="md-input col-xs-12"  placeholder="Last Name *"/>

                        <input id="email" type="text" name="email" class="md-input col-xs-12"  placeholder="Email *"/>

                        <input name="password" type="password" class="md-input col-xs-12"  placeholder="Password *"/>

                        <input name="password_confirmation" type="password" class="md-input col-xs-12"  placeholder="Confirm Password *" style="margin-bottom: 15px"/><br>

                        <input class="md-check" name="subscribe" type="checkbox" id="accepts_marketing" checked/> Recieve promotional emails
                        <input type="submit" name="submit" class="md-button narrow" value="submit">
                        {{ csrf_field() }}
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
