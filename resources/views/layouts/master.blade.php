<!DOCTYPE html>
<html>
<head>

    <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <title>@yield('title') | Ecommerce</title>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="Description" content="@yield('description')"/>
    <meta name="Keywords" content="@yield('keywords')"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="" type="image/png">
    <link rel="icon" href="" type="image/png">
    <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Josefin+Sans:100,300,400,700' rel='stylesheet' type='text/css'>
    <link href="{{ url('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    <script src="{{ url('js/jquery-1.11.0.min.js') }}"></script>
    <script src="{{ url('js/jquery-migrate-1.2.1.js') }}"></script>
    <link rel="stylesheet" href="{{ url('css/slider1.css') }}">
	<link rel="stylesheet" href="{{ url('css/style.css') }}">
	<link rel="stylesheet" href="{{ url('css/animate.min') }}.css">
	<link rel="stylesheet" href="{{ url('css/responsive.css') }}">
    <link rel="stylesheet" href="{{ url('css/style.css') }}">
	<link rel="stylesheet" href="{{ url('css/prettyPhoto.css') }}">
	<link rel="stylesheet" href="{{ url('css/dataslider.css') }}">
	<link rel="stylesheet" href="{{ url('css/responsive.css') }}">
    <link rel="stylesheet" href="{{ url('css/chosen.css') }}">
	<link rel="stylesheet" href="{{ url('css/style.css') }}">
	<link rel="stylesheet" href="{{ url('css/responsive.css') }}">

    <style type="text/css">
        .md-button,
        .ls-card-form .submit-button {
            background-color: rgb(52, 169, 148);
        }
        
        .md-button:hover,
        .ls-card-form .submit-button:hover {
            background-color: #2d8e7d;
        }
        
        .top-cart-price{
            color: rgb(52, 169, 148);
        }
        
        .total-buble{
            background-color: rgb(52, 169, 148);
        }

        a:hover{
            color: rgb(52, 169, 148);
        }
        .section-footer:before{
            background-color: rgb(52, 169, 148);
        }
        header:after{
            background-color: rgb(52, 169, 148);
        }
        .section-aboutus-page .members-holder .member-item .position, .section-stats .stat-item .value, .content-holder.about-us p a{
            color: rgb(52, 169, 148);
        }
        .content-holder.about-us p a{
            border-bottom: 1px solid rgb(52, 169, 148);
        }
        .grid-list-buttons li.active i{
            color: rgb(52, 169, 148);
        }
        .address-column p a{
            color: rgb(52, 169, 148);
        }

        .product-item:hover .product-item{
            padding-bottom:0;
            height:460px;
        }
        .breadcrumb{
            border-bottom:solid rgb(52, 169, 148) 6px;
        }
        .single-product-info-holder .nav-area-holder .back a{
            color:rgb(52, 169, 148)5;
        }
    </style>


</head>

<body class="homepage3">
    <div class="wrapper">
    
	<header>
	    <div class=" container">
	        <section class="style-one-header top-area">
	            <div class="row">
	                <div class="col-sm-4 col-xs-12">
	                    <div class="login-menu-holder ic-sm-user">
	                            @if($user = Sentinel::check())
	                            Welcome, {{ $user->user }}
	                            <a href="{{ url('logout') }}">Logout</a>
	                            @else
	                            <a href="{{ url('login') }}">Login or Register</a>
	                            @endif
	                    </div>
	                    <!--<div class="hotline-holder ic-sm-phone">
	                        <label>hotline:</label>
	                        <span>1-800-123-4567</span>
	                    </div>-->
	                </div>
	                <div class="top-logo-holder col-sm-4 col-xs-12">

	                    <div class="top-logo">
	                      <a href="{{ url('/') }}"><!--<img src="{{ url('images/logo-big.png') }}" alt="" class="logo">--></a>
	                    </div>

	                </div>
	                <div class="col-sm-4 col-xs-12">
	                    <div class="wish-cart-holder">
	                        <div class="top-cart-holder ic-sm-basket" id="mini-cart">
	                            <a href="{{ url('cart') }}">shopping cart</a>:
								<span class="top-cart-price">IDR 0</span>
								<div class="total-buble">
								    <span>0</span>
								</div>

								<div class="hover-holder">
								    <ul class="basket-items ">
									    <li class="row">
									        <div class="thumb col-xs-3">
									            <!--<img width="45" height="45" alt="" src="{{ url('images/products/product03.jpg') }}" />-->
									        </div>
									        <div class="body col-xs-9">
									            <h5>item.product.name</h5>
									            <div class="price">
									                <span>IDR 0</span>
									            </div>
									            <a class="remove-item" href="#"
									                data-ajax-handler="shop:cart" 
									                data-ajax-update="#cart-content=shop-cart-content, #mini-cart=shop-minicart"
									                data-ajax-extra-fields="delete_item='0'">x</a>
									        </div>
									    </li>
									</ul>
								    <a class="top-chk-out md-button" href="/cart">check out</a>
								</div>
	                        </div>
	                        <div class="search-holder">
	                            <form action="search" method="get">
	                                <input type="text" name="query" id="query" placeholder="Search" autocomplete="off" value="">
	                            </form>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </section>
	        <div class="top-menu visible-md visible-lg">
			    <ul>
			      	<li><a href="{{ url('/')}}">HOME</a></li>
                    @php
                        $parent_menu = \App\Models\Menu::getParentMenus();
                    @endphp
                        @foreach($parent_menu as $parent)
                            @php 
                            	$child_menu = \App\Models\Menu::getChildMenus($parent->id);
                            @endphp
                            @if(count($child_menu) > 0)
                                <li id="{{ $parent->path }}-navigation">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">{{ strtoupper($parent->title)}}
                                        <b class="caret"></b>
                                    </a>
                                    <ul class="dropdown-menu" role="menu">
                                        @foreach($child_menu as $key=>$child)
                                        <li><a href="{{ url('/'.$child->path) }}">{{$child->title}}</a></li>
                                        @endforeach
                                    </ul>
                                </li>
                            @else
                                <li class="{{$parent->path}}-navigation" id="{{$parent->path}}-navigation">
                                <a href="{{ url('/'.$parent->path) }}">{{ strtoupper($parent->title) }}</a></li>
                            @endif
                        @endforeach
			        @if($user = Sentinel::check())
			        <li>
			           <a href="{{ url('order') }}">My Orders</a>
			        </li>
			        <li>
			           <a href="{{ url('profil') }}">My Profile</a>
			        </li>
			        @else
			        <li>
			        	<a href="{{ url('login') }}">Login</a>
			        </li>
			        @endif
			    </ul>
			</div>


			<select class="top-drop-menu  visible-sm visible-xs">
			    <option value="{{ url('/') }}">
			        Home
			    </option>
			    @php
                        $parent_menu = \App\Models\Menu::getParentMenus();
                    @endphp
                        @foreach($parent_menu as $parent)
                            @php 
                            	$child_menu = \App\Models\Menu::getChildMenus($parent->id);
                            @endphp
                            @if(count($child_menu) > 0)
                                <li id="{{ $parent->path }}-navigation">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">{{ strtoupper($parent->title)}}
                                        <b class="caret"></b>
                                    </a>
                                    <ul class="dropdown-menu" role="menu">
                                        @foreach($child_menu as $key=>$child)
                                        <li><a href="{{ url('/'.$child->path) }}">{{$child->title}}</a></li>
                                        @endforeach
                                    </ul>
                                </li>
                            @else
                                <option value=""{{ url('/'.$parent->path) }}">{{ strtoupper($parent->title) }}</option>
                            @endif
                        @endforeach
			    	@if($user = Sentinel::check())
			        <option value="{{ url('orders') }}">
			            My Orders
			        </option>
			        <option value="{{ url('profile') }}">
			            My Profile
			        </option>
			        @endif
			</select>
	    </div>
	</header>

        
		@yield('content')


		<section class="section-newsletter">
		    <div class="container">
		        <div class="news-letter-holder">
		            <form>
		                <div class="row">
		                    <div class="newsletter-title col-xs-12 col-sm-4">
		                        <h2>sign up to our newsletter</h2>
		                        <h3>and get $30 coupon</h3>
		                    </div>

		                    <div class=" col-xs-12 col-sm-8">
		                        <div class="newsletter-body">
		                            <input class="md-input col-xs-12 col-sm-7" placeholder="Enter here your email"> <button class="md-button black narrow">sign up</button>
		                        </div>
		                    </div>
		                </div>
		            </form>
		        </div>
		    </div>
		</section>

		<section class="section-banners">
		    <div class="container">
		        <div class="col-lg-6 col-md-12">
		            <div class="homepage-banner">
		                <a href="#"><img class="lazy" width="584" height="211"></a>
		            </div>
		        </div>
		        <div class="col-lg-6 col-md-12">
		            <div class="homepage-banner">
		                <a href="#"><img class="lazy" width="584" height="211"></a>
		            </div>
		        </div>
		    </div>
		</section>

        <section class="section-footer">
		    <div class="footer-holder">
		        <div class="container">
		            <div class="col-xs-offset-2 col-xs-8 col-sm-6 col-sm-offset-0  col-md-3">
		                <div class="footer-column adress-column">
		                    <h4>connect with us</h4>

		                    <div class="content">
		                        <p class="bold">eCommerce</p>
		                        <p>
		                        </p>
		                        <div class="footer-socials">
		                            <ul>
		                                <li>
		                                    <a href="" class="fa fa-facebook"></a>
		                                </li>
		                                <li>
		                                    <a href="" class="fa fa-twitter"></a>
		                                </li>
		                                <li>
		                                    <a href="" class="fa fa-pinterest"></a>
		                                </li>
		                            </ul>
		                        </div>

		                    </div>

		                </div>
		            </div>


		            <div class="col-xs-offset-2 col-xs-8 col-sm-6 col-sm-offset-0  col-md-3">
		                <div class="footer-column">
		                    <h4>shop</h4>

		                    <div class="content">
								    <ul class="categories-group link-list">
								            <li>
								                <a href="/category/">category.name</a>
								            </li>
								    </ul>
								    <ul class="categories-group link-list sub-category">
								            <li>
								                <a href="/category/">category.name</a>
								            </li>
								    </ul>
		                    </div>

		                </div>
		            </div>


		            <div class="col-xs-offset-2 col-xs-8 col-sm-6 col-sm-offset-0  col-md-3">
		                <div class="footer-column">
		                    <h4>my account</h4>

		                    <div class="content">
		                        <ul class="link-list">
		                                <li><a href="/orders" title="My Orders">My Orders</a></li>
		                                <li><a href="/profile" title="My Profile">My Profile</a></li>
		                                <li><a href="/logout" title="Logout">Logout</a></li>
		                                <li><a href="/login" title="Login / Register">Login / Register</a></li>
		                        </ul>

		                    </div>

		                </div>
		            </div>

		            <div class="col-xs-offset-2 col-xs-8 col-sm-6 col-sm-offset-0  col-md-3">
						  <div class="footer-column">
						    <h4>our support</h4>
						    <div class="content">
						      <ul class="link-list">
						        <li>
						          <a href="">terms &amp; conditions</a>
						        </li>

						        <li>
						          <a href="">delivery</a>
						        </li>
						        <li>
						          <a href="">secure payment</a>
						        </li>

						        <li>
						          <a href="/contact">contact us</a>
						        </li>

						        <li>
						          <a href="">refunds</a>
						        </li>

						        <li>
						          <a href="">track orders</a>
						        </li>
						        <li>
						          <a href="">services</a>
						        </li>
						      </ul>
						    </div>
						  </div>
					</div>
		        </div>
		    </div>

		    <div class="footer-payment-icons">
		        <ul class="list-inline">
		            <li>
		              <img  alt="paypal" src="{{ url('images/payments-paypal.png') }}" />
		            </li>
		            <li>
		              <img alt="visa" src="{{ url('images/payments-visa.png') }}" />
		            </li>
		            <li>
		              <img alt="master card" src="{{ url('images/payments-mastercard.png') }}" />
		            </li>
		            <li>
		              <img alt="discover" src="{{ url('images/payments-discover.png') }}" />
		            </li>
		            <li>
		              <img alt="amex" src="{{ url('images/payments-amex.png') }}" />
		            </li>
		        </ul>
		        <div class="powered pull-right">Recreative</div>
		    </div>
		</section>

    
    </div>
    
    <script src="{{ url('js/bootstrap.min.js') }}"></script>

	    <script type="text/javascript" src="{{ url('js/css_browser_selector.js') }}"></script>
		<script type="text/javascript" src="{{ url('js/jquery.carouFredSel-6.2.1-packed.js') }}"></script>
		<script type="text/javascript" src="{{ url('js/jquery.easing-1.3.js') }}"></script>
		<script type="text/javascript" src="{{ url('js/jquery.flexslider-min.js') }}"></script>

	    <script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false&amp;language=en"></script>
		<script type="text/javascript" src="{{ url('js/chosen.jquery.min.js') }}"></script>
		<script type="text/javascript" src="{{ url('js/gmap3.min.js') }}"></script>
		<script type="text/javascript" src="{{ url('js/jquery.raty.min.js') }}"></script>
		<script type="text/javascript" src="{{ url('js/bootstrap-slider.js') }}"></script>
		<script type="text/javascript" src="{{ url('js/jquery.lazyload.min.js') }}"></script>

		<script type="text/javascript" src="{{ url('js/jquery.prettyPhoto.js') }}"></script>

		<script type="text/javascript" src="{{ url('js/jquery.icheck.min.js') }}"></script>
		<script type="text/javascript" src="{{ url('js/jquery.creditCardValidator.js') }}"></script>  

	<script type="text/javascript" src="{{ url('js/script.js') }}"></script>
    
</body>
</html>
