@extends('layouts.master')
@section('title', 'Reset Password')
@section('content')
<section class="section-checkout-page">
    <div class="container">
                <div class="checkout-accordions">
                    @if(\Request::get('ac'))
                    <div class="panel-body">
                        <form action="{{ url('password-reset') }}" method="post">
                            <p>Please enter a new password for your account below and confirm the change.</p>
                            <div class="row">
                                <div class="field-row col-xs-12 col-md-4">
                                    <label for="password" class="hide">New password</label>
                                    <input type="password" id="password" name="password" value="" placeholder="New password" class="md-input"/>
                                    <span class="error"></span>
                                </div>
                                
                                <div class="field-row col-xs-12 col-md-4">
                                    <label for="passwordConfirm" class="hide">Password confirmation</label>
                                    <input type="password" name="password_confirmation" value="" placeholder="Password confirmation"  class="md-input"/>
                                    <span class="error"></span>
                                </div>
                                
                                <div class="field-row col-xs-12 col-md-4">
                                    <input type="submit" class="button md-button col-xs-12" value="Set new password" name="password_restore_submit"/>
                                </input>
                            </div>
                        </form>
                    @else                
                        <div id="passwordRestoreRequestForm">
                        <form action="{{ url('password-reset') }}" method="post">
                                @if(!empty(session('error')))
                                <span class="error">{{ $error }}</span>
                                @endif
                                <p>Please enter your email below, we will send you an email message with a link to enter a new password for your account.<p>
                                <div class="row">
                                    <div class="field-row col-xs-12 col-md-9">
                                        <input type="text" id="email" name="email" class="md-input" placeholder="E-mail Address"/>
                                        <span class="error"></span>
                                    </div>
                                    <div class="field-row col-xs-12 col-md-3">
                                        <input type="submit" class="button md-button col-xs-12" value="Submit" name="passwordRestoreSubmit"/>
                                    </div>
                                </div>
                                {{ csrf_field() }}
                        </div>
                        </form>
                    </div>
                    @endif
              </div>
    </div>
</section>
@endsection