@extends('layouts.master')

@section('title','Cart')

@section('content')
<section>
<div class="row">
<div class="col-md-12 col-lg-9">
    <div class="items-holder">
        @foreach($cart as $content)
		<div class="cart-item row">
		    <div class="col-sm-2 col-lg-1">
		        <div class="image">
		            <img width="60" height="60" alt="" src="" />
		        </div>
		    </div>
		    <div class="col-sm-4 col-lg-6">
		        <div class="brand">
		        </div>
		        <div class="title">
		            <a href="{{ url('product/'.str_slug($content->name)) }}">{{ $content->name }}</a>
		            <ul class="options">
		        @if(isset($description))
		          <li>{{ $description }}</li>
		        @endif
		      </ul>
		        </div>
		        <div class="bulk-pricing">
		            @if(isset($discount))
		                <p class="bold">Bulk Pricing</p>
		                <div class="widget shopping-cart-summary">
		                    <table class="volume-pricing-table">
		                        <thead><tr><td>Qty</td><td>Price</td></tr></thead>  
		                        <tr>
		                            <td>
		                                
		                            </td>
		                            <td>{{ $content->price }}</td>
		                        </tr>
		                    </table>
		                </div>
		            @endif
		        </div>
		    </div>
		    <div class="col-sm-6 col-lg-5 details">
		        <div class="unit-price">
		             {{ $content->price }} 
		        </div>
		        <div class="quantity">
		                <input type="text" name="item_quantity" class="md-input quantity" value="{{ $content->qty }}"> 
		        </div>
		        <div class="total-price">
		             {{ $content->price }} 
		        </div>
		            <a></a> 
		    </div>
		</div>
		@endforeach

    </div>            
</div>
@if(count($cart) > 0)
<div id="cart-totals">
<div class="col-md-12 col-lg-3">
    <div class="right-sidebar">
     
        <div class="widget shopping-cart-summary">
            <h4 class="md-bordered-title">shopping cart summary</h4>
            <form>

                 @if(isset($total)) 
                    <fieldset>
                        <label class="col-xs-6">discount</label>
                        <span class="col-xs-6 value"></span>
                    </fieldset>
                 @endif 

                <fieldset>
                    <label class="col-xs-6">cart subtotal</label>
                    <span class="col-xs-6 value"></span>
                </fieldset>

                 @if(\Request::get('shop')) 
                    <fieldset>
                        <label class="col-xs-6">sales tax</label>
                        <span class="col-xs-6 value">totals.totalTax</span>
                    </fieldset>
                    <fieldset>
                        <label class="col-xs-6">shipping</label>
                        <span class="col-xs-6 value"> totals.totalShippingQuote</span>
                    </fieldset>
                    <hr>
                    <fieldset class="total">
                        <label class="col-xs-6">order total</label>
                        <span class="col-xs-6 value"> totals.total|currency </span>
                    </fieldset>
                 @else  

                    <input class="md-input col-xs-12" placeholder="coupon code" value="" name="coupon" id="coupon"/>

                    <a class="md-button black" href="#">Update cart</a>

                     @if (\Auth::check()) 
                        <a class="md-button large col-xs-12" href=" url('/checkout') ">Checkout</a>
                            <a href="{{ url('shop') }}">continue shopping</a>
                     @else 
                        <a class="md-button large col-xs-12" href="{{ url('checkout') }}">Checkout</a>
                            <a href="{{ url('shop') }}">continue shopping</a>
                     @endif 

                 @endif
            </form>
        </div> 
    </div>
</div>
</div>
@else
<div class="col-md-4"></div>
<div class="col-md-4">
    <div class="items-holder"> 
        <h4 class="md-bordered-title">Your cart is empty!</h4>
        <a class="md-button col-xs-12 cart-empty-button" href="{{ url('shop') }} ">Continue shopping <span class="fa fa-arrow-circle-right"></span></a>
  	</div>
</div>
@endif
</div>
</section>
@endsection