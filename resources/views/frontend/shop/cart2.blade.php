@extends('layouts.default')

@section('title','Cart')

@section('content')
<div class="container cart-container">
	<div class="row">
		{% if cart.listitems|length %}
	  {{ open_form({'class': 'custom'}) }}
	    <div id="cart-content">{{ partial('shop-cart-content') }}</div>
	  {{ close_form() }}    
	 	{% else %}
	 	<div class="col-md-12">
			<div class="col-md-12">
				<h4>There are no items in your cart!</h4>
	 			<a href="/shop">Continue Shopping</a>
			</div>
	 	</div>
	 {% endif %}
	</div>
</div>