@extends('layouts.master')
@section('title', 'Reset Password')
@section('content')
<section class="section-checkout-page">
    <div class="container">
                <div class="checkout-accordions">
                    <div class="panel-body">
                        <form action="#" method="post">
                            <p>Harap masukan kode otp</p>
                            <div class="row">
                                <div class="field-row col-xs-12 col-md-4">
                                    <label for="kodeotp" class="hide">Kode OTP</label>
                                    <input type="text" id="password" name="kodeotp" placeholder="Kode OTP" class="md-input"/>
                                    <span class="error"></span>
                                </div>
                                
                                <div class="field-row col-xs-12 col-md-4">
                                    <input type="submit" class="button md-button col-xs-12" value="Submit" name="password_restore_submit"/>
                                </input>
                                </div>
                                <input type="hidden" value="{{ $id }}" name="id" />
                                {{ csrf_field() }}
                            </div>
                        </form>
                    </div>
                </div>
    </div>
</section>
@endsection