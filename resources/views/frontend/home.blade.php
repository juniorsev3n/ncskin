@extends('layouts.master')

@section('title', 'Welcome')
@section('content')

<section class="section-home-banner">
		    	<div id="myCarousel" class="carousel slide" data-ride="carousel">
				  <!-- Indicators -->
				  <ol class="carousel-indicators">
				    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
				    <li data-target="#myCarousel" data-slide-to="1"></li>
				    <li data-target="#myCarousel" data-slide-to="2"></li>
				  </ol>

				  <!-- Wrapper for slides -->
				  <div class="carousel-inner">
				    <div class="item active">
				      <img src="images/homepage-3-banner.jpg" alt="Los Angeles" class="lazy">
				    </div>

				    <div class="item">
				      <img src="images/homepage-3-banner.jpg" alt="Chicago">
				    </div>

				    <div class="item">
				      <img src="images/homepage-3-banner.jpg" alt="New York">
				    </div>
				  </div>

				  <!-- Left and right controls -->
				  <a class="left carousel-control" href="#myCarousel" data-slide="prev">
				    <span class="glyphicon glyphicon-chevron-left"></span>
				    <span class="sr-only">Previous</span>
				  </a>
				  <a class="right carousel-control" href="#myCarousel" data-slide="next">
				    <span class="glyphicon glyphicon-chevron-right"></span>
				    <span class="sr-only">Next</span>
				  </a>
				</div>
		      <!--<img class="lazy" src="images/homepage-3-banner.jpg" />-->
		</section>

		<section id="homepage-products-tab" class="section-products-grid">
		    <div class="container">

		        <!-- Nav tabs -->
		        <div class="tab-nav-holder">
		            <ul class="nav-tabs">
		                <li>
		                    <a class="active-tab tab-control" href="#featured" data-toggle="featured">featured</a>
		                </li>

		                <li class="active">
		                    <a class="active-tab tab-control" href="#whats-new" data-toggle="whats-new">what's new</a>
		                </li>
		            </ul>
		        </div>

		        <div class="tab-tag-line uppercase bold">
		            we have over 200 products in our shop
		        </div>

		        <div class="tab-content product-grid no-move-down">
		            <div class="tab-pane" id="featured">
		                <div class="row">
						        @foreach ($products as $product)
                                <div class="col-lg-4 col-xs-12 col-sm-6 product-holder">
                                    <form class="custom" onsubmit="return false">
                                    <div class="product-item text-center">
                                        @php 
                                        $images = json_decode($product->images, TRUE);
                                        @endphp
                                        @if (count($images) > 1)
                                            <a href="#next" class="mini-next"></a>
                                            <a href="#prev" class="mini-prev"></a>
                                            <div class="image ">
                                                <div class="product-mini-gallery">
                                                    @foreach ($images as $key => $value)
                                                    <a style="display:inline-block;" href="/product/{{ $product->slug }}">
                                                        <img alt="{{ $product->name }}" src="{{ $value }}" width="212" height="281" />
                                                    </a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @else
                                            <a href="/product/{{ $product->slug }}">
                                                <img class="product-img" src="{{ $images }}" alt="{{ $product->name }}" />
                                            </a>
                                        @endif
                                        <hr>
                                        <div class="title uppercase bold">
                                            <a href="/product/{{ $product->slug }}">{{ $product->name }}</a>
                                        </div>
                                        <div class="price">
                                            @if ($product->is_discount == TRUE)
                                                    <span class="previous-price">{{ $product->pricet - ($product->discount * $product->price) }}</span>
                                            @endif
                                            <span>{{ $product->price }}</span>
                                        </div>
                                        <div class="buttons-holder">
                                            <div class="add-cart-holder">
                                                <input type="hidden" name="productId" value="{{ $product->id }}"/>
                                                <a class="md-button" href="#" data-ajax-handler="shop:onAddToCart" data-ajax-update="#mini-cart=shop-minicart, #product-page=shop-product">Add to Cart</a>
                                            </div>
                                        </div>
                                    </div>
                                    </form>
                                </div>
                            @endforeach
		                </div>
		            </div><!-- /featured -->

		            <div class="tab-pane active" id="whats-new">
		                <div class="row">
        <div class="col-lg-offset-0 col-lg-3 col-sm-4 col-sm-offset-1 col-xs-10 col-xs-offset-2 product-holder">
        </div>
						        <div class="col-lg-offset-0 col-lg-3 col-sm-4 col-sm-offset-1 col-xs-10 col-xs-offset-2 product-holder">
									<form class="custom" onsubmit="return false">
									<div class="product-item text-center">
									        <a href="#next" class="mini-next"></a>
									        <a href="#prev" class="mini-prev"></a>
									        <div class="image ">
									            <div class="product-mini-gallery">
									                <a style="display:inline-block;" href="/product/product.url_name">
									                    <img alt="product.name" src="images/products/product01.jpg" width="212" height="281" />
									                </a>
									                <a style="display:inline-block;" href="/product/product.url_name">
									                    <img alt="product.name" src="images/products/product02.jpg" width="212" height="281" />
									                </a>
									            </div>
									        </div>
									    <hr>
									    <div class="title uppercase bold">
									        <a href="/product/product.url_name">name</a>
									    </div>
									    <div class="price">
									            <span class="previous-price">IDR 0</span>
									        <span>IDR 1</span>
									    </div>
									    <div class="buttons-holder">
									        <div class="add-cart-holder">
									            <input type="hidden" name="productId" value="product.id }}"/>
									            <a class="md-button" href="#" data-ajax-handler="shop:onAddToCart" data-ajax-update="#mini-cart=shop-minicart, #product-page=shop-product">Add to Cart</a>
									        </div>
									    </div>
									</div>
									</form>
						        </div>
						        <div class="col-lg-offset-0 col-lg-3 col-sm-4 col-sm-offset-1 col-xs-10 col-xs-offset-2 product-holder">
									<form class="custom" onsubmit="return false">
									<div class="product-item text-center">
									        <a href="#next" class="mini-next"></a>
									        <a href="#prev" class="mini-prev"></a>
									        <div class="image ">
									            <div class="product-mini-gallery">
									                <a style="display:inline-block;" href="/product/product.url_name">
									                    <img alt="product.name" src="images/products/product01.jpg" width="212" height="281" />
									                </a>
									                <a style="display:inline-block;" href="/product/product.url_name">
									                    <img alt="product.name" src="images/products/product02.jpg" width="212" height="281" />
									                </a>
									            </div>
									        </div>
									    <hr>
									    <div class="title uppercase bold">
									        <a href="/product/product.url_name">product.name</a>
									    </div>
									    <div class="price">
									            <span class="previous-price">IDR 0</span>
									        <span>IDR 1</span>
									    </div>
									    <div class="buttons-holder">
									        <div class="add-cart-holder">
									            <input type="hidden" name="productId" value="product.id }}"/>
									            <a class="md-button" href="#" data-ajax-handler="shop:onAddToCart" data-ajax-update="#mini-cart=shop-minicart, #product-page=shop-product">Add to Cart</a>
									        </div>
									    </div>
									</div>
									</form>
						        </div>	        
		                </div>
		            </div>
		        </div>
		    </div>
		</section>
@endsection