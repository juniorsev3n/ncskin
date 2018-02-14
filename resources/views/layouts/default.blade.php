<!DOCTYPE html> 
<!--[if IE 8]> <html lang="en"> <![endif]--> 
<!--[if gt IE 8]><!--> <html lang="en"> <!--<![endif]--> 
<head>
    <title>@yield('title') | {{ config('custom.name') }}</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="Description" content="{{ config('custom.description') }}"/>
<meta name="Keywords" content="{{ config('custom.keywords') }}"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" type="image/png" href="{{ url('images/favicon.png') }}"/>

<link rel="shortcut icon" href="{{ url('/images/favicon.png') }}" type="image/png">
<link rel="icon" href="{{ url('/images/favicon.png') }}" type="image/png">


<link href='https://fonts.googleapis.com/css?family=Cabin:400,500,600,700' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<link rel="stylesheet" href="{{ url('/stylesheets/yamm.css') }}">

<link rel="stylesheet" href="{{ url('/stylesheets/main.css') }}">
<link rel="stylesheet" href="{{ url('/stylesheets/checkout.css') }}">
<link rel="stylesheet" href="{{ url('/stylesheets/custom.css') }}">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

<style>

.home-feature {
 	/*background: url()no-repeat center right;*/
 	-webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
}

@media screen and (max-width: 992px) {
  .home-feature {
  -webkit-background-size: 100%;
  background-size: 100%;
  }
}
@media screen and (max-width: 480px) {
	.home-feature {
  -webkit-background-size: 90%;
  background-size: 90%;
	}
  
}
</style>

</head> 
<body>
    <div class="promotion-bar">
  <p>
    Sign up for the newsletter and get 15% off!
    <a class="delete-promotion"><i class="fa fa-times"></i></a>
  </p>
</div>


<nav class="navbar yamm navbar-default">
  <div class="container-fluid container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="{{ url('/') }}">{{ config('custom.name') }}</a>

      <!-- logo in the header  -->
      <a class="navbar-logo" href="{{ url('/') }}"><img src="{{ url('images/logo.png') }}" alt="{{ config('custom.name') }}" width="150" /></a>

    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="dropdown yamm-fw">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Shop</a>
          <ul class="dropdown-menu shop-drop">
          <li>
            <div class="container yamm-content">
            	@php
            	$categories = \App\Models\Category::all();
            	@endphp
            @foreach($categories as $category)
              <ul class="cat-box">
              	@if($category->parent_id > 0)
	                <li class="parent-cat"><a href="/category/{{ $category->slug }}">{{ $category->name }}</a></li>
	                <ul>
	                @php
	                	$child = \App\Models\Category::where('parent_id', $category->parent_id);
	                @endphp
	                @foreach($child as $c)
	                  <li><a href="/category/{{ $c->slug }}">{{ $c->name}}</a></li>
	                @endforeach
	                </ul>
             	@else
                <li class="parent-cat"><a href="/category/{{ $category->slug }}">{{ $category->name}}</a></li>
             	@endif
              </ul>
            @endforeach
            </div>
          </ul>
          </li>

          <li class="dropdown yamm-fw">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">About</a>
            <ul class="dropdown-menu shop-drop default-drop">
              <div class="container yamm-content">
                <ul class="cat-box">
                  <li><a href="/about">About Us</a></li>
                  <li><a href="/contact">Contact Us</a></li>
                </ul>
              </div>
            </ul>
          </li>

          <li class="dropdown yamm-fw">
            <a href="/blog" class="dropdown-toggle">Blog</a>
          </li>


        <li class="dropdown yamm-fw">
          <ul class="dropdown-menu shop-drop default-drop">
            <div class="container yamm-content">
              <ul class="cat-box">
                <li><a href="/blog">Blog</a></li>
              </ul>
            </div>
          </ul>
        </li>

      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown yamm-fw login-drop">
          @auth
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ Sentinel::check()->first_name }}</a>
          @endauth
          @guest
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Login</a>
          @endguest
          <ul class="dropdown-menu shop-drop" id="login-drop">
          <li>
            <div class="yamm-content">
            @auth
            <a class="btn btn-important" href="{{ url('profile') }}"> Profile</a>
			<br>
			<a class="btn btn-important" href="{{ url('logout') }}"> Logout</a>
            @endauth
            @guest
              <div class="col-md-12">
			        @if (session('status'))
			        <div class="alert alert-success">
			            {{ session('status') }}
			        </div>
			        @endif
			        @if (session('error'))
			        <div class="alert alert-danger">
			            {{ session('error') }}
			        </div>
			        @endif

			    <div class="row">
			        <div class="col-sm-12">

			            <p>RETURNING CUSTOMERS</p>

			            <form data-ajax-handler="shop:onLogin" data-validation-message="" class="form-horizontal">

			                <div class="form-group">
			                    <div class="col-sm-12">
			                        <input type="email" class="form-control input-sm" id="login_email" placeholder="Email Address" name="email" value="{{ old('email') }}" size="40" />
			                        <span class="error small text-danger"></span>
			                    </div>
			                </div>

			                <div class="form-group">
			                    <div class="col-sm-12">
			                        <input type="password" class="form-control input-sm" id="login_password" placeholder="Password" name="password" size="20" />
			                        <span class="error small text-danger"></span>
			                    </div>
			                </div>

			                <div class="form-group">
			                    <div class="col-sm-12">
			                        <button type="submit" class="btn btn-important" id="login_button">Login</button>
			                        <a class="btn btn-sm btn-link forgotpass" href="{{ url('password-restore') }}">Forgot your password?</a>
			                    </div>
			                </div>
			                
			                <input type="hidden" name="redirect" value="{{ url('/') }}"/>
			      
			            </form>
			        </div>
			    
			        <div class="col-sm-12">
			    
			            <p >NEW CUSTOMERS</p>
			  
			            <form data-ajax-handler="shop:onSignup" data-validation-message="" class="form-horizontal">

			                <div class="form-group">
			                    <div class="col-sm-12">
			                        <input type="text" class="form-control input-sm" id="signup[first_name]" placeholder="First Name *" name="signup[first_name]" value="{{ old('signup[first_name]') }}" size="16"/>
			                        <span class="error small text-danger"></span>
			                    </div>
			                </div>
			                <div class="form-group">
			                    <div class="col-sm-12">
			                        <input type="text" class="form-control input-sm" id="signup[last_name]" placeholder="Last Name *" name="signup[last_name]" value="{{ old('signup[last_name]') }}" size="16"/>
			                        <span class="error small text-danger"></span>
			                    </div>
			                </div>


			                <div class="form-group">
			                    <div class="col-sm-12">
			                        <input type="email" class="form-control input-sm" id="signup[email]" placeholder="Email Address *" name="signup[email]" value="{{ old('signup[email]') }}" size="40" />
			                        <span class="error small text-danger"></span>
			                    </div>
			                </div>

			                <div class="form-group">
			                    <div class="col-sm-12">
			                        <input type="password" class="form-control input-sm" id="signup[password]" placeholder="Password *" name="signup[password]" value="" size="16" />
			                        <span class="error small text-danger"></span>
			                    </div>
			                </div>

			                <div class="form-group">
			                    <div class="col-sm-12">
			                        <input type="password" class="form-control input-sm" id="signup[password_confirmation]" placeholder="Password Confirm *" name="signup[password_confirmation]" value="" size="16" />
			                        <span class="error small text-danger"></span>
			                    </div>
			                </div>

			                <div class="form-group">
			                    <div class="col-sm-12">
			                        <input type="checkbox" name="accepts_marketing" id="accepts_marketing" checked/>Receive promotional emails
			                    </div>
			                </div>

			                <div class="form-group">
			                    <div class="col-sm-12">
			                        <button type="submit" class="btn btn-sm btn-important">Submit</button>
			                    </div>
			                </div>

			                <input type="hidden" name="autologin" value="1" />

			            </form>

			        </div>
			    </div>
			</div>

            @endguest
            </div>
          </ul>
        </li>
        <li class="dropdown yamm-fw login-drop" >
          <a href="#" class="search-botton dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Search</a>
          <ul class="dropdown-menu shop-drop">
            <form class="search" method="get" action="{{ url('search') }}">
              <input class="search-box" type="text" name="query" value="{{ old('query') }}" placeholder="Search store&hellip;"/>
            </form>
          </ul>
          
        </li>

        <li class="dropdown yamm-fw login-drop" >
            <a href="#" class="dropdown-toggle" id="cart-totals" data-toggle="dropdown">
            	<span id="navbar-totals">
				  <span class="cart-icon"></span>
				  <span class="cart-items">
				    {{ Cart::total() }}
				  </span>
				</span>
			</a>
          <ul class="dropdown-menu shop-drop" id="login-drop">
          <li>
            <div class="yamm-content" id="mini-cart">
              @if(Cart::count() > 0)
			  <ul class="cart-items list-unstyled hidden-xs">
			    @foreach (Cart::content() as $item)
			    <li class="row cart-item">
			        <div class="product-thumb col-xs-4">
			            <img class="img-responsive" alt="{{ $item->name }}" src="http://placehold.it/100x100" />
			        </div>
			        <div class="product-info col-xs-8">
			            <h6 class="product-title">{{ $item->name }}</h6>
			            <div class="price">
			                {{ $item->qty }} x <span>{{ $item->price }}</span>
			            </div>
			            <a class="remove-item" href="#"
			              data-ajax-handler="shop:cart" 
			          data-ajax-update="#mini-cart=shop-minicart, #cart-totals=shop-minicart-totals"
			          data-ajax-extra-fields="delete_item='{{ $item->id }}'"><i class="fa fa-times"></i></a>
			        </div>
			    </li>
			    @endforeach
			  </ul>
			    <div class="mini-cart-totals">
			      <hr>
			      <h4 class="subtotal text-center">Subtotal: {{ Cart::subTotal() }}</h4>
			      <a class="btn btn-sm btn-link forgotpass col-xs-12" href="{{ site_url('/cart') }}">View Cart</a><br>
			      @auth
			      <a class="col-xs-12 btn btn-important" href="{{ site_url('/checkout') }}">Checkout</a>
			      @endauth
			      @guest
			      <a class="col-xs-12 btn btn-important" href="{{ site_url('/checkout-start') }}">Checkout</a>
			      @endguest
			    </div>
			@else
			  <h6>No items in cart.</h6>
			@endif
			<br><br>
            </div>
          </ul>
        </li>
      </ul>
      

    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

<!--<div class="container-fluid product-breadcrumb text-center">
	<h4>
		<a href="/">Home</a>
		<span>/</span>
	</h4>
</div>-->

    @yield('content')

<div class="container-fluid newsletter">
	<div class="container">
		<div class="row">
			<div class="col-xs-12 text-center">
				<h3 class="col-xs-12 col-sm-4">Sign up for updates</h3>
				<div class="form-group col-xs-12 col-sm-8">
			      <div>
			      	<form id="mc-form">
			      		<input type="email" class="form-control input-sm" placeholder="Email Address" size="40" id="mc-email"/>	
			      		<label for="mc-email"></label>
			      		<button class="btn btn-default">Submit</button>
			      	</form>
			      </div>
        		</div>
			</div>
		</div>
	</div>
</div>

<footer>
	<div class="container">
		<div class="row">
			<div class="col-md-3">
				<ul>
					<li><a class="head">Shop</a></li>
			@foreach($categories as $category)
            <li><a href="/category/{{ $category->slug }}">{{ $category->name}}</a></li>
        	@endforeach
				</ul>
			</div>
			<div class="col-md-3">
				<ul>
					<li><a class="head">About</a></li>
					<li><a href="/about">About Us</a></li>
					<li><a href="/contact">Contact Us</a></li>
				</ul>
			</div>
			<div class="col-md-3">
				<ul>
					<li><a class="head">Legal</a></li>
					<li><a href="">Deliver</a></li>
					<li><a href="">Terms and Conditions</a></li>
					<li><a href="">Warranty</a></li>
					<li><a href="">Help and FAQ</a></li>
				</ul>
			</div>
			<div class="col-md-3">
				<ul>
					<li><a class="head">More</a></li>
					@auth
						<li><a href="/profile">Profile</a></li>
					@endauth
					@guest
					<li><a href="">Sign up for Newsletter</a></li>
					@endguest
				</ul>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 social-foot text-center">
				<h5>Follow us Socially</h5>
				<ul>
					<li><a href="#" target="_blank"><i class="fa fa-facebook"></i></a></li>
					<li><a href="#" target="_blank"><i class="fa fa-twitter"></i></a></li>
					<li><a href="#" target="_blank"><i class="fa fa-instagram"></i></a></li>
					<li><a href="#" target="_blank"><i class="fa fa-medium"></i></a></li>
				</ul>
				
			</div>
		</div>
	</div>
</footer>

<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script src="{{ url('js/ajaxchimp.min.js') }}"></script>
<script src="{{ url('js/hammer.min.js') }}"></script>
<script src="{{ url('js/slider.min.js') }}"></script>
<script src="{{ url('js/main.js') }}"></script>
<script src="{{ url('js/checkout.js') }}"></script>

<script type="text/javascript">
	$('#mc-form').ajaxChimp({
	    url: 'https://neucome.us17.list-manage.com/subscribe/post?u=3837563b3d0cbd9806ea54fb3&amp;id=96542bad17'
	});
</script>

</body>
</html>