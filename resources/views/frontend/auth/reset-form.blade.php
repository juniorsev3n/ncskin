@extends('layouts.master')
@section('title', 'Reset Password')
@section('content')
<section class="section-checkout-page">
    <div class="container">
                <div class="checkout-accordions">
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
                                {{ csrf_field() }}
                            </div>
                        </form>
                    </div>
                </div>

    </div>
</section>
@endsection